<?php

namespace App\Helpers;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Cache;

class AcademicYearHelper
{
    /**
     * Get the active academic year.
     *
     * @return string
     */
    public static function getActiveYear()
    {
        return Cache::remember('active_academic_year', 86400, function () {
            $activeYear = AcademicYear::where('is_active', true)->first();
            return $activeYear ? $activeYear->year : 'TAHUN AJARAN BELUM DIATUR';
        });
    }
}