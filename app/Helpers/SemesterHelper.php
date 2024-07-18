<?php

namespace App\Helpers;

class SemesterHelper
{
    public static function getSemesters()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $prevYear = $currentYear - 1;

        $semesters = [
            "Ganjil {$prevYear}/{$currentYear}",
            "Genap {$prevYear}/{$currentYear}",
            "Ganjil {$currentYear}/{$nextYear}",
            "Genap {$currentYear}/{$nextYear}",
        ];

        return $semesters;
    }

    public static function getCurrentSemester()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $prevYear = $currentYear - 1;
        $month = date('n');

        // Assume that Ganjil is from July to December and Genap is from January to June
        if ($month >= 7 && $month <= 12) {
            return "Ganjil {$currentYear}/{$nextYear}";
        } else {
            return "Genap {$prevYear}/{$currentYear}";
        }
    }
}
