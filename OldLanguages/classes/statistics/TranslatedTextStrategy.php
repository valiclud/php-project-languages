<?php

namespace classes\statistics;

class TranslatedTextStrategy implements CalculateStatisticStrategy
{
    private $allTexts;

    public function __construct(private \classes\DatabaseTable $textTable)
    {
    }
    public function calculateNumberOfAuthors(): int
    {
        $texts = $this->getAllTranslatedTexts();
        return count(array_unique(array_column($texts, 'author_id')));
    }
    public function calculateNumberOfTexts(): int
    {
        $texts = $this->getAllTranslatedTexts();
        return count($texts);
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
    public function calculateNoOfLanguages(): int {
        return -1;
    }
    private function getAllTranslatedTexts()
    {
        if (empty($this->allTexts)) {
            $this->allTexts = $this->textTable->findAll();
        }
        return $this->allTexts;
    }
}
