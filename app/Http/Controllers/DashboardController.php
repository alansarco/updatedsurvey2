<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGraduates = Graduate::count();
        $employedGraduates = Graduate::where('employed', 1)->orWhere('employed', 2)->count();

        $employmentRate = $totalGraduates > 0 ? round(($employedGraduates / $totalGraduates) * 100, 1) : 0;

        // Get all graduates with user info
        $users = Graduate::with('user')
            ->latest()
            ->paginate(10);

        // Get statistics
        $graduatesByYear = Graduate::select('graduation_year', DB::raw('count(*) as total'))
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->get();

        $employmentStatus = Graduate::select('current_employment', DB::raw('count(*) as total'))
            ->groupBy('current_employment')
            ->get();

        $hasSubmitted = Graduate::where('user_id', auth()->id())->exists();
        $departments = [
            'Engineering Organizations' => [
                ['name' => 'ICpEP.SE', 'desc' => 'Institute of Computer Engineer of the Philippines - Student Edition', 'icon' => 'bi-cpu', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'PIChE', 'desc' => 'Philippine Institute of Chemical Engineers', 'icon' => 'bi-capsule', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'IECEP', 'desc' => 'Institute of Electronics Engineers', 'icon' => 'bi-tv', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'PSME', 'desc' => 'Philippine Society of Mechanical Engineers', 'icon' => 'bi-gear', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'PICE', 'desc' => 'Philippine Institute of Civil Engineers', 'icon' => 'bi-building', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CES', 'desc' => 'Ceramic Engineering Society', 'icon' => 'bi-boxes', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'IIEE', 'desc' => 'Institute of Electrical Engineers', 'icon' => 'bi-lightning', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'PSABE', 'desc' => 'Philippine Society of Agricultural and Biosystems Engineers', 'icon' => 'bi-tools', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843']
            ],
            'Colleges' => [
                ['name' => 'COE', 'desc' => 'College of Engineering', 'icon' => 'bi-people', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CCIS', 'desc' => 'College of Computing and Information Sciences', 'icon' => 'bi-pc-display', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CHS', 'desc' => 'College of Health Sciences', 'icon' => 'bi-shield', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CAS', 'desc' => 'College of Arts and Sciences', 'icon' => 'bi-book', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CTE', 'desc' => 'College of Teacher Education', 'icon' => 'bi-pencil', 'link' =>  'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CBEA', 'desc' => 'College of Business, Economics, and Accountancy', 'icon' => 'bi-briefcase', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CVM', 'desc' => 'College of Veterinary Medicine', 'icon' => 'bi-capsule-pill', 'link' =>'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CAFSD', 'desc' => 'College of Agriculture, Food and Sustainable Development', 'icon' => 'bi-flower1', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'COM', 'desc' => 'College of Medicine', 'icon' => 'bi-prescription', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'COL', 'desc' => 'College of Law', 'icon' => 'bi-bank', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843'],
                ['name' => 'CASAT', 'desc' => 'College of Aquatic Sciences and Applied Technology', 'icon' => 'bi-droplet-half', 'link' => 'https://www.facebook.com/profile.php?id=100063648476843']
            ]
        ];

        // Get survey response statistics
        $totalUsers = \App\Models\User::where('email', '!=', 'admin@gmail.com')->count();
        $respondedUsers = Graduate::count();
        $notRespondedUsers = $totalUsers - $respondedUsers;

        $surveyStats = [
            'responded' => $respondedUsers,
            'notResponded' => $notRespondedUsers,
            'responseRate' => $totalUsers > 0 ? round(($respondedUsers / $totalUsers) * 100, 1) : 0
        ];

        return view('dashboard', compact(
            'totalGraduates',
            'employedGraduates',
            'employmentRate',
            'graduatesByYear',
            'employmentStatus',
            'hasSubmitted',
            'users',
            'departments',
            'surveyStats'
        ));
    }
}
