<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraduateController extends Controller
{
    public function index()
    {
        $graduates = Graduate::with('user')->latest()->paginate(10);
        return view('graduates.index', compact('graduates'));
    }

    public function create()
    {
        if (Graduate::where('user_id', auth()->id())->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'You have already submitted your graduate survey.');
        }
        return view('graduates.create');
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();

            $validated = $request->validate([
                'graduation_year' => 'required|numeric',
                'employment_status' => 'required',
                'phone_number' => 'required|string|max:20',
                'gender' => 'required|in:male,female',
                'facebook' => 'nullable|string',
                'position' => 'nullable|string',
                'company_name' => 'nullable|string',
                'company_address' => 'nullable|string',
                'industry_sector' => 'nullable|string',
                'is_cpe_related' => 'nullable|in:0,1',
                'has_awards' => 'nullable|in:0,1',
                'is_involved_organizations' => 'nullable|in:0,1',
                'lifelong_learner' => 'nullable|in:0,1',
                'photo' => 'nullable|image|max:2048'
            ]);

            $graduate = new Graduate();
            $graduate->user_id = auth()->id();
            $graduate->graduation_year = $validated['graduation_year'];
            $graduate->phone_number = $validated['phone_number'];
            $graduate->gender = $validated['gender'];
            $graduate->facebook = $validated['facebook'];
            // $graduate->employed = in_array($validated['employment_status'], ['employed', 'self-employed']);
            $graduate->employed = $validated['employment_status'];

            // Handle employment details
            // if (in_array($validated['employment_status'], ['employed', 'self-employed'])) {
            if ($validated['employment_status']) {
                $graduate->position = $request->position;
                $graduate->company_name = $request->company_name;
                $graduate->company_address = $request->company_address;
                $graduate->industry_sector = $request->industry_sector;
                $graduate->is_cpe_related = $request->is_cpe_related;
                $graduate->has_awards = $request->has_awards;
                $graduate->is_involved_organizations = $request->is_involved_organizations;
            }

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('photos', 'public');
                $graduate->photo = $path;
            }

            $graduate->save();
            \DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Survey submitted successfully');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Survey submission error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error submitting survey');
        }
    }

    public function show(Graduate $graduate)
    {
        return view('graduates.show', compact('graduate'));
    }

    public function edit(Graduate $graduate)
    {
        return view('graduates.edit', compact('graduate'));
    }

    public function update(Request $request, Graduate $graduate)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'graduation_year' => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            'facebook' => 'nullable|string|max:255',
            'employment_status' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $graduate->phone_number = $validated['phone_number'];
        $graduate->gender = $validated['gender'];
        $graduate->graduation_year = $validated['graduation_year'];
        $graduate->facebook = $validated['facebook'];
        $graduate->employed = $validated['employment_status'];
        $graduate->current_employment = $validated['employment_status'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('graduates', 'public');
            $graduate->photo = $path;
        }

        $graduate->save();

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate information updated successfully!');
    }

    public function destroy(Graduate $graduate)
    {
        try {
            $graduate->delete();
            return redirect()->route('graduates.index')
                ->with('success', 'Graduate deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('graduates.index')
                ->with('error', 'Error deleting graduate.');
        }
    }
}
