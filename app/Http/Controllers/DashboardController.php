<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ActivityLog; 
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts of students, teachers, and subjects in the database
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $subjectsCount = Subject::count();
        $schedulesCount = Schedule::count();

        // Get the latest 5 activities from the activity logs table
        $activities = ActivityLog::latest()->take(15)->get();

        // Pass data to the view to display the dashboard
        return view('dashboard', compact('studentsCount', 'teachersCount', 'subjectsCount', 'schedulesCount', 'activities'));
    }
    public function deleteLogs()
{
    // Delete all activity logs from the database
    ActivityLog::truncate(); // This will delete all records in the activity_logs table 

    // Redirect back with a success message to the dashboard
    return redirect()->route('dashboard')->with('success', 'Activity logs have been deleted.');
}
}
