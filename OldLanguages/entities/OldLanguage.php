<?php

namespace entities;

class OldLanguage
{

    public $id;

    public $language;

    public $period;

    public static function default(): self
    {
        return self::from(0, "", "");
    }

    public static function from(int $id, String $language, String $period): self
    {
        $instance = new self();
        $instance->id        = $id;
        $instance->language     = $language;
        $instance->period   = $period;

        return $instance;
    }

    private function __construct()
    {
    }
}
