<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

class ExperienceCalculator
{
    public static function calculateLvl(int $experience): int
    {
        $lvl = 1;
        if ($experience === 0) {
            return $lvl;
        }

        $experience /= 10;
        if ($experience < 1) {
            return $lvl;
        }
        $lvl++;

        while (($experience /= 2) >= 1) {
            $lvl++;
        }

        return $lvl;
    }

    public static function calculateExp(int $lvl): int
    {
        if ($lvl < 1) {
            throw new \UnexpectedValueException();
        }

        if ($lvl === 1) {
            return 0;
        }

        return 10 * pow(2, $lvl - 2);
    }
}
