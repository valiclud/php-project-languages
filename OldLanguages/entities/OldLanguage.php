<?php

namespace entities;

class OldLanguage
{

    public $id;

    public $language;

    public $period;

    public function __construct(
        //private DatabaseTable $originalTextsTable,
        //private ?\classes\DatabaseTable $oldLanguagesTable
    ) {
    }
/**
    public function getOriginalTexts()
    {
        return $this->originalTextsTable->find('old_language_id', $this->id);
    }

    public function getOldLanguageById()
    {
        return $this->oldLanguagesTable->find('id', $this->id)[0];
    }
    */
}
