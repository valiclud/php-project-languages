<?php

namespace classes\statistics;

class OriginalTextStrategy implements CalculateStatisticStrategy {

    public function calculateNumberOfAuthors():int {
        return 1;

    }
    public function calculateNumberOfTexts(): int {
        return 1;
    }
    public function calculateNumberOfRevisions(): int {
        return 1;

    }
    public function calculateAverageRevisionPerText(): float{
        return 1;

    }
    public function calculateAverageAccessInDays() : float {
        return 1;

    }

 
}