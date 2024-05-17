<?php

namespace controllers;

class StatisticController
{

    private ?\classes\statistics\StatisticsCalculation $statisticsTransText;
    private ?\classes\statistics\StatisticsCalculation $statisticsOrigText;

    public function __construct(
        private \classes\DatabaseTable $translatedTextTable,
        private \classes\DatabaseTable $originalTextTable
    ) {
        $this->statisticsTransText =
            new \classes\statistics\StatisticsCalculation(new \classes\statistics\TranslatedTextStrategy($translatedTextTable));
        $this->statisticsOrigText =
            new \classes\statistics\StatisticsCalculation(new \classes\statistics\OriginalTextStrategy($originalTextTable));
    }


    public function list()
    {
        $noOfAuthorsTransText = $this->statisticsTransText->calcNoOfAuthorsTranslatedTexts();
        $noOfTransText = $this->statisticsTransText->calcNoOfTranslatedTexts();
        $noOfOriginalLanguages = $this->statisticsOrigText->calculateNoOfLanguages();

        $title = 'Statistics';

        return ['template' => 'statistics.html.php', 'title' => $title, 'variables' => [
            'noOfAuthorsTransText' => $noOfAuthorsTransText,
            'noOfTransText' => $noOfTransText,
            'noOfOrigLanguage' => $noOfOriginalLanguages
        ]];
    }
}
