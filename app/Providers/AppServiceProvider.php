<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\AcademicYearHelper;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Observers\StudentObserver;
use App\Observers\SchoolClassObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share active academic year with all views
        View::share('activeAcademicYear', AcademicYearHelper::getActiveYear());

        // Register model observers
        Student::observe(StudentObserver::class);
        SchoolClass::observe(SchoolClassObserver::class);
    }
}
