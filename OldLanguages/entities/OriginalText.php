<?php

namespace entities;

class OriginalText
{

    public $id;

    public $author_text;

    public $title;

    public $text;

    public $text_img;

    public $century;

    public $insert_date;

    public $hits;

    public $place_id;

    public $old_language_id;

    public ?object $place = null;

    public ?object $oldLanguage = null;

    public static function default($placesTable, $oldLanguagesTable): self
    {
        return self::from(
            "",
            "",
            "",
            null,
            "",
            date_create(),
            0,
            Place::from(0, "", ""),
            OldLanguage::from(0, "", ""),
            $placesTable,
            $oldLanguagesTable
        );
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
        ?OldLanguage $oldLanguage,
        \classes\DatabaseTable $placesTable,
        \classes\DatabaseTable $oldLanguagesTable
    ) {
        $instance = new self($placesTable, $oldLanguagesTable);
        $instance->author_text = $author;
        $instance->title = $title;
        $instance->text = $text;
        $instance->text_img = $text_img;
        $instance->century = $century;
        $instance->insert_date = $insert_date;
        $instance->hits = $hits;
        $instance->place = $place;
        $instance->oldLanguage = $oldLanguage;

        return $instance;
    }

    public function __construct(private \classes\DatabaseTable $placesTable, private \classes\DatabaseTable $oldLanguagesTable)
    {
    }
    public function setAuthor(String $author): void
    {
        $this->author_text = $author;
    }
    public function getAuthor() {
        return $this->author_text;
    }
    public function setTitle(String $title): void
    {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }
    public function setText(String $text): void
    {
        $this->text = $text;
    }
    public function getText() {
        return $this->text;
    }
    public function setTextimg(String $textimg): void
    {
        $this->text_img = $textimg;
    }
    public function getTextimg() {
        return $this->text_img;
    } 
    public function setCentury(String $century): void
    {
        $this->century = $century;
    }
    public function getCentury() {
        return $this->century;
    } 
    public function setInsertdate(String $insertdate): void
    {
        $this->insert_date = $insertdate;
    }
    public function getInsertdate() {
        return $this->insert_date;
    }
    public function setHits(String $hits): void
    {
        $this->hits = $hits;
    }
    public function getHits() {
        return $this->hits;
    } 
    public function setPlace(?object $place) {
$       $this->place = $place;
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
    public function setOldLanguage(?object $oldLanguage) {
        $       $this->oldLanguage = $oldLanguage;
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
