<?php

namespace entities;

class OldLanguage
{

    public $id;

    public $old_text;

    public $insert_date;

    public $author_id;

    public $new_originaltext_id;

    public $new_translatedtext_id;

    private ?object $author = null;

    private ?object $new_originaltext = null;
    private ?object $new_translatedtext = null;

    public static function default($authorTable, $originalTextTable, $translatedTextTable): self
    {
        return self::from(
            "",
            date_create(),
             null, 
             null,
             null,
             $authorTable,
             $originalTextTable,
             $translatedTextTable
            );
    }

    public static function from(
        String $old_text, 
        \DateTime $insert_date,
        ?Author $author,
        ?OriginalText $new_originaltext,
        ?TranslatedText $new_translatedtext,
        \classes\DatabaseTable $authorTable,
        \classes\DatabaseTable $originalTextTable,
        \classes\DatabaseTable $translatedTextTable
        ) {
        $instance = new self($authorTable, $originalTextTable,$translatedTextTable);
        $instance->old_text = $old_text;
        $instance->insert_date = $insert_date;
        $instance->new_originaltext = $new_originaltext;
        $instance->new_translatedtext = $new_translatedtext;

        return $instance;
    }

    private function __construct(private \classes\DatabaseTable $authorTable, 
    \classes\DatabaseTable $originalTextTable,
    \classes\DatabaseTable $translatedTextTable)
    {
    }

    public function getAuthor()
    {
        if (empty($this->author)) {
            $this->author = $this->authorTable->find('id', $this->author_id)[0];
        }
        return $this->author;
    }

}
