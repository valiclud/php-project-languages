<?php

namespace entities;

class OriginalText
{

    public $id;

    public $author;

    public $title;

    public $text;

    public $textImg;

    public $century;

    public $insert_date;

    public $hits;

    public $place_id;

    public $old_language_id;

    public function __construct(
        private ?\classes\DatabaseTable $placesTable,
        private ?\classes\DatabaseTable $oldLanguagesTable
    ) {
    }

    public function getPlace()
    {
        return $this->placesTable->find('id', $this->place_id)[0];
    }

    public function getAllPlaces()
    {
        return $this->placesTable->findAll();
    }

    public function getOldLanguage()
    {
        return $this->oldLanguagesTable->find('id', $this->old_language_id)[0];
    }

    public function getAllOldLanguages()
    {
        return $this->oldLanguagesTable->findAll();
    }
    
}
