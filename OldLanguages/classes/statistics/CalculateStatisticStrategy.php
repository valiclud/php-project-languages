<?php

namespace classes\statistics;
interface CalculateStatisticStrategy {
    public function calculateNumberOfAuthors() : int;
    public function calculateNumberOfTexts() : int;
    public function calculateNumberOfRevisions() : int;
    public function calculateAverageRevisionPerText() : float;
    public function calculateAverageAccessInDays() : float;
    public function calculateNoOfLanguages(): int;

}