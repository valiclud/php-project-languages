<?php

namespace entities;

class TranslatedText
{
    public $id;

    public $title;

    public $text;

    public $insert_date;

    public $language;

    public $revision;

    public $original_text_id;

    public $author_id;

    private ?object $originalText;

    private ?object $author;

    public function __construct(
        private \classes\DatabaseTable $originalTextsTable,
        private \classes\DatabaseTable $authorsTable
    ) {
    }

    public function getAuthor() {
        if (empty($this->author)) {
            $this->author = $this->authorsTable->find('id', $this->author_id)[0];
        }
        return $this->author;
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

    public function getAllAuthors()
    {
        return $this->authorsTable->findAll();
    }
}

