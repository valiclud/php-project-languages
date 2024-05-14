<?php 

namespace classes\statistics;

class StatisticsCalculation {

    private $strategy;
    
    public function __construct(CalculateStatisticStrategy $strategy) {
        $this->strategy = $strategy;
    }
    
    public function calculateTime() {
        return $this->strategy->calculateAverageAccessInDays();
    }

    public function calcNoOfAuthorsTranslatedTexts() {
       return $this->strategy->calculateNumberOfAuthors();
    }

    public function calcNoOfTranslatedTexts() {
        return $this->strategy->calculateNumberOfTexts();
     }
}