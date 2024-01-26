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

    public $original_text_id;

    private ?object $originalText;

    public function __construct(
        private ?\classes\DatabaseTable $originalTextsTable
    ) {
    }

    public function getOriginalText()
    {
        if (empty($this->originalText)) {
            $this->originalText = $this->originalTextsTable->find('id', $this->original_text_id)[0];
        }
        return $this->originalText;
    }

    public function getAllOriginalTexts()
    {
        return $this->originalTextsTable->findAll();
    }
}
