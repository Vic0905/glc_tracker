<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateStudentSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:generate_student_schedule {--days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a student schedule for the next given number of days';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $days = $this->option('days'); // Get the number of days from the command option
    
        // Fetch today's schedule
        $today = Carbon::today();
        $scheduleData = Schedule::whereDate('schedule_date', $today)->get();
    
        // Generate schedules for the next 'x' days
        foreach ($scheduleData as $schedule) {
            for ($i = 1; $i <= $days; $i++) {
                $newSchedule = $schedule->replicate();
                $newSchedule->schedule_date = $today->copy()->addDays($i); // Corrected line
                $newSchedule->save();
            }
        }
    
        $this->info("Schedules generated for the next {$days} days.");
    }
    
    
}
