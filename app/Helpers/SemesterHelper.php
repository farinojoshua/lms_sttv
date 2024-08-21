<?php

namespace App\Helpers;

class SemesterHelper
{
    /**
     * Get a list of semesters for the last X years.
     *
     * @param int $yearsBack Number of years to go back from the current year.
     * @return array
     */
    public static function getSemesters($yearsBack = 5)
    {
        $currentYear = date('Y');
        $semesters = [];

        for ($i = $yearsBack; $i >= 0; $i--) {
            $startYear = $currentYear - $i;
            $endYear = $startYear + 1;

            $semesters[] = "Ganjil {$startYear}/{$endYear}";
            $semesters[] = "Genap {$startYear}/{$endYear}";
        }

        return $semesters;
    }

    /**
     * Get the current semester based on the current month.
     *
     * @return string
     */
    public static function getCurrentSemester()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $prevYear = $currentYear - 1;
        $month = date('n');

        // Assume Ganjil (odd) semester is from July to December and Genap (even) semester is from January to June
        if ($month >= 7 && $month <= 12) {
            return "Ganjil {$currentYear}/{$nextYear}";
        } else {
            return "Genap {$prevYear}/{$currentYear}";
        }
    }
}
