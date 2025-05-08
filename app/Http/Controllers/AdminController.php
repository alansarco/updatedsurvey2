<?php

namespace App\Http\Controllers;

use App\Mail\NotifyEmail;
use App\Models\Graduate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@gmail.com') {
            return redirect()->route('login');
        }
        $year = $request->year ?? date('Y');
        $fromYear = $request->year1 ?? date('Y');
        $toYear = $request->year ?? date('Y');
        if ($fromYear > $toYear) {
            $toYear = $fromYear;
        }

        $totalGraduates = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->count();

        $employedGraduates = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('employed', 1)
            ->count();

        $employmentRate = $totalGraduates > 0 ?
            round(($employedGraduates / $totalGraduates) * 100, 1) : 0;

        // Using the employed field instead of current_employment
        $employedCount = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('employed', 1)->count();

        // For self-employed and unemployed, we need to determine how they're stored
        // Option 1: If you have a separate field for self-employed
        // $selfEmployedCount = Graduate::where('position', 'like', '%self%')
        //     ->orWhere('company_name', 'like', '%self%')
        //     ->count();
        $selfEmployedCount = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('employed', 2)->count();

        // Option 2: If unemployed is simply not employed
        $unemployedCount = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('employed', 0)->count();

        // Get counts by year
        $totalGraduatesByYear = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->select('graduation_year', DB::raw('count(*) as total'))
            ->groupBy('graduation_year')
            ->pluck('total', 'graduation_year')
            ->toArray();

        $lifelongLearners = 0; // Default value if field doesn't exist

        $employmentByYear = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->select(
                'graduation_year',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when employed = 0 then 1 else 0 end) as employed'),
                DB::raw('sum(case when employed = 1 then 1 else 0 end) as unemployed'),
                DB::raw('sum(case when employed = 2 then 1 else 0 end) as self_employed'),
            )
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->get();

        $lifelongLearners = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('lifelong_learner', 1)->count();

        $genderDistribution = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();

        // Add industry sector distribution
        $industrySectors = Graduate::select('industry_sector', DB::raw('count(*) as count'))
            ->whereNotNull('industry_sector')
            ->groupBy('industry_sector')
            ->get();

        // Add CPE-related work statistics
        $cpeRelatedWork = Graduate::
            when($fromYear && $toYear, function ($query) use ($fromYear, $toYear) {
                return $query->whereBetween('graduation_year', [$fromYear, $toYear]);
            })
            ->where('is_cpe_related', true)->count();
        $cpeRelatedPercentage = $totalGraduates > 0 ?
            round(($cpeRelatedWork / $totalGraduates) * 100, 1) : 0;

        return view('admin.dashboard', compact(
            'totalGraduates',
            'employedGraduates',
            'employmentRate',
            'employmentByYear',
            'genderDistribution',
            'industrySectors',
            'cpeRelatedWork',
            'cpeRelatedPercentage',
            'employedCount',
            'selfEmployedCount',
            'unemployedCount',
            'totalGraduatesByYear',
            'lifelongLearners'
        ));
    }

    public function graduates(Request $request)
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@gmail.com') {
            return redirect()->route('login');
        }

        $query = Graduate::with('user');

        // Filter by graduation year if selected
        if ($request->has('year') && $request->year) {
            $query->where('graduation_year', $request->year);
        }

        $graduates = $query->latest()->paginate(10);

        // Keep pagination working with the filter
        if ($request->has('year')) {
            $graduates->appends(['year' => $request->year]);
        }

        return view('admin.graduates', compact('graduates'))
            ->with('backUrl', route('admin.dashboard')); // Add back URL context
    }

    public function notify(Request $request)
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@gmail.com') {
            return redirect()->route('login');
        }
        // Validate the uploaded file
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('excel_file')->store('uploads');
        $fullPath = storage_path('app/' . $path);
        $reader = ReaderEntityFactory::createReaderFromFile(storage_path('app/' . $path));
        $reader->open(storage_path('app/' . $path));

        // Load the Excel file
        DB::beginTransaction(); // Begin a transaction
        $firstRow = true;

        try {
            foreach ($reader->getSheetIterator() as $sheet) {
                $rowNumber = 1;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($firstRow) {
                        $firstRow = false; // Skip the first row (header)
                        continue;
                    }
                    $rowNumber++; // Increment row number for each data row

                    $cells = $row->getCells();
                                    
                    if (!empty($cells[0]) && !empty($cells[1])) {
                        $name = isset($cells[0]) ? $cells[0]->getValue() : null;
                        $email = isset($cells[1]) ? $cells[1]->getValue() : '';

                        Mail::to($email)->send(new NotifyEmail($name));
                    }
                }
            }
            
            DB::commit(); // Commit transaction if all rows pass validation
            $reader->close();

            sleep(1);
            
            // Try deleting with Storage, and if it fails, use unlink
            try {
                Storage::delete($path) || unlink($fullPath);
            } catch (\Exception $e) {
                return response()->json(['status' => 500, 'message' => 'Failed to delete uploaded file: ' . $e->getMessage()]);
            }

            return redirect()->route('admin.graduates')->with('success', 'Graduate notified successfully');

        }
        catch (\Exception $e) {
            return back()->withErrors(['excel_file' => 'Failed to read Excel file. Error: ' . $e->getMessage()]);
        }

    }

    public function notifypage(Request $request)
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@gmail.com') {
            return redirect()->route('login');
        }

        return view('admin.notifypage')
        ->with('success', 'Graduate notified successfully');
    }

    public function edit(Graduate $graduate)
    {
        return view('admin.graduates.edit', compact('graduate'))
            ->with('backUrl', route('admin.graduates')); // Add back URL context
    }

    public function update(Request $request, Graduate $graduate)
    {
        $validated = $request->validate([
            'phone_number' => 'required|numeric|max:20',
            'gender' => 'required|in:male,female',
            'graduation_year' => 'required|numeric',
            'facebook' => 'nullable|string',
            'employment_status' => 'required|in:employed,self-employed,unemployed'
        ]);

        $graduate->update([
            'phone_number' => $validated['phone_number'],
            'gender' => $validated['gender'],
            'graduation_year' => $validated['graduation_year'],
            'facebook' => $validated['facebook'],
            'employed' => in_array($validated['employment_status'], ['employed', 'self-employed']),
            'current_employment' => $validated['employment_status']
        ]);

        return redirect()->route('admin.graduates')
            ->with('success', 'Graduate updated successfully');
    }

    public function destroy(Graduate $graduate)
    {
        $graduate->delete();
        return redirect()->route('admin.graduates')
            ->with('success', 'Graduate deleted successfully');
    }
    // Add this method to your AdminController
    public function getYearStats($year)
    {
        // Query for graduates of the selected year
        $totalGraduates = DB::table('users')
            ->where('graduation_year', $year)
            ->count();

        // Get employed count for the selected year
        $employedCount = DB::table('users')
            ->where('graduation_year', $year)
            ->where('employed', 1)
            ->count();

        // Get unemployed count for the selected year
        $unemployedCount = DB::table('users')
            ->where('graduation_year', $year)
            ->where('employed', 0)
            ->count();

        // Get lifelong learners count (you may need to adjust this query based on your definition)
        $lifelongLearners = DB::table('users')
            ->where('graduation_year', $year)
            ->where('current_employment', 'graduate') // Adjust this condition as needed
            ->count();

        return response()->json([
            'totalGraduates' => $totalGraduates,
            'employedCount' => $employedCount,
            'unemployedCount' => $unemployedCount,
            'lifelongLearners' => $lifelongLearners
        ]);
    }

    public function exportCsv()
    {
        $graduates = Graduate::with('user')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=graduates.csv'
        ];

        $callback = function () use ($graduates) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Phone', 'Gender', 'Graduation Year', 'Employment']);

            foreach ($graduates as $graduate) {
                $employment_status = match ($graduate->employed) {
                    1 => 'employed',
                    2 => 'self-employed',
                    default => 'unemployed',
                };

                fputcsv($file, [
                    $graduate->user->name,
                    $graduate->user->email,
                    $graduate->phone_number,
                    $graduate->gender,
                    $graduate->graduation_year,
                    $employment_status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function employmentStats($year)
    {
        $stats = [
            'employed' => Graduate::where('current_employment', 'employed')
                ->where('graduation_year', $year)
                ->count(),
            'selfEmployed' => Graduate::where('current_employment', 'self-employed')
                ->where('graduation_year', $year)
                ->count(),
            'unemployed' => Graduate::where('current_employment', 'unemployed')
                ->where('graduation_year', $year)
                ->count(),
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'employedTrend' => [],
            'selfEmployedTrend' => [],
            'unemployedTrend' => []
        ];

        // Get monthly trends by graduation year instead of created_at
        for ($month = 1; $month <= 12; $month++) {
            $stats['employedTrend'][] = Graduate::where('current_employment', 'employed')
                ->where('graduation_year', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $stats['selfEmployedTrend'][] = Graduate::where('current_employment', 'self-employed')
                ->where('graduation_year', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $stats['unemployedTrend'][] = Graduate::where('current_employment', 'unemployed')
                ->where('graduation_year', $year)
                ->whereMonth('created_at', $month)
                ->count();
        }

        return response()->json($stats);
    }

    public function getSurveyData(Graduate $graduate)
    {
        try {
            $graduate->load('user');
            $data = array_merge($graduate->toArray(), [
                'name' => $graduate->user->name,
                'email' => $graduate->user->email,
                'created_at' => $graduate->created_at,
                'updated_at' => $graduate->updated_at
            ]);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load survey data'], 500);
        }
    }
}
