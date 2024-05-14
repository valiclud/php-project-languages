<?php

namespace controllers;

class StatisticController {

    private ?\classes\statistics\StatisticsCalculation $statisticsTransText;

	public function __construct(
		private \classes\DatabaseTable $translatedTextTable,
        private \classes\DatabaseTable $originalTextTable
	) {
        $this->statisticsTransText = 
        new \classes\statistics\StatisticsCalculation(new \classes\statistics\TranslatedTextStrategy($translatedTextTable));
	}


    public function list() {
        $noOfAuthorsTransText = $this->statisticsTransText->calcNoOfAuthorsTranslatedTexts();
        $noOfTransText = $this->statisticsTransText->calcNoOfTranslatedTexts();
        $title = 'Statistics';

    	return ['template' => 'statistics.html.php', 'title' => $title, 'variables' => [
			'noOfAuthorsTransText' => $noOfAuthorsTransText,
            'noOfTransText' => $noOfTransText
		]];
	}
}