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

    private ?object $place = null;

    private ?object $oldLanguage = null;

    public static function default(): self
    {
        return self::withAttributes("", "", "", null, "", date_create(), 0, null, null);
    }

    public static function from(
        String $author,
        String $title,
        String $text,
        $text_img,
        String $century,
        \DateTime $insert_date,
        int $hits,
        ?Place $place,
        ?OldLanguage $oldLanguage
    ) {
        return self::withAttributes($author, $title, $text, $text_img, $century, $insert_date, $hits, $place, $oldLanguage);
    }

    public static function withAttributes(
        String $author,
        String $title,
        String $text,
        $text_img,
        String $century,
        \DateTime $insert_date,
        int $hits,
        ?\classes\DatabaseTable $placesTable,
        ?\classes\DatabaseTable $oldLanguagesTable
    ): self {
        $instance = new self($placesTable, $oldLanguagesTable);
        $instance->author = $author;
        $instance->title = $title;
        $instance->text = $text;
        $instance->text_img = $text_img;
        $instance->century = $century;
        $instance->insert_date = $insert_date;
        $instance->hits = $hits;
        $instance->placesTable = $placesTable;
        $instance->oldLanguagesTable = $oldLanguagesTable;

        return $instance;
    }

    public function __construct(
        private ?\classes\DatabaseTable $placesTable,
        private ?\classes\DatabaseTable $oldLanguagesTable
    ) {
    }

    public function setAuthor(String $author): void
    {
        $this->author = $author;
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
