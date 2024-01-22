<?php

namespace entities;

class TranslatedText
{
    public $id;

    public $author;

    public $title;

    public $text;

    public $language;

    public $inserDate;

    public $revision;

    public $originalTextId;

    public function __construct(
        //private DatabaseTable $originalTextsTable,
        private ?\classes\DatabaseTable $translatedTextsTable
    ) {
    }

    public function getOriginalTexts()
    {
        return $this->translatedTextsTable->find('original_text_id', $this->originalTextId);
    }

    public function getTranslatedText()
    {
        return $this->translatedTextsTable->find('id', $this->id)[0];
    }
}
