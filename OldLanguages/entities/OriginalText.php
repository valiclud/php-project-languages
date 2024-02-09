<?php

namespace entities;

class OriginalText
{

    public $id;

    public $author;

    public $title;

    public $text;

    public $text_img;

    public $century;

    public $insert_date;

    public $hits;

    public $place_id;

    public $old_language_id;

    private ?object $place;

    private ?object $oldLanguage;

    public function __construct(
        private ?\classes\DatabaseTable $placesTable,
        private ?\classes\DatabaseTable $oldLanguagesTable
    ) {
    }

    public function getPlace()
    {
        if (empty($this->place)) {
            $this->place = $this->placesTable->find('id', $this->place_id)[0];
        }
        return $this->place;
    }

    public function getAllPlaces()
    {
        return $this->placesTable->findAll();
    }

    public function getOldLanguage()
    {
        if (empty($this->oldLanguage)) {
            $this->oldLanguage = $this->oldLanguagesTable->find('id', $this->old_language_id)[0];
        }
        return $this->oldLanguage;
    }

    public function getAllOldLanguages()
    {
        return $this->oldLanguagesTable->findAll();
    }
    
}
