<?php

namespace classes\statistics;

class OriginalTextStrategy implements CalculateStatisticStrategy
{

    private $allTexts;

    public function __construct(private \classes\DatabaseTable $textTable)
    {
    }

    public function calculateNumberOfAuthors(): int
    {
        return 1;
    }
    public function calculateNumberOfTexts(): int
    {
        return 1;
    }
    public function calculateNumberOfRevisions(): int
    {
        return 1;
    }
    public function calculateAverageRevisionPerText(): float
    {
        return 1;
    }
    public function calculateAverageAccessInDays(): float
    {
        return 1;
    }
    public function calculateNoOfLanguages(): int
    {
        $texts = $this->getAllOriginalTexts();
        $final  = array();

        foreach ($texts as $value) {
            if (!in_array($value->old_language_id, $final)) {
                $final[] = $value->old_language_id;
            }
        }
        return count($final);
    }

    private function getAllOriginalTexts()
    {
        if (empty($this->allTexts)) {
            $this->allTexts = $this->textTable->findAll();
        }
        return $this->allTexts;
    }

    private function filterLanguage($var)
    {
        // returns whether the input integer is odd
        return $var & 1;
    }
}
