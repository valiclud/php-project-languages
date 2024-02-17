<?php


namespace entities;

class Place
{

    public $id;

    public $place;

    public $country;

    public static function default(): self
    {
        return self::from(0, "", "");
    }

    public static function from(int $id, String $place, String $country): self
    {
        $instance = new self();
        $instance->id        = $id;
        $instance->place     = $place;
        $instance->country   = $country;

        return $instance;
    }

    private function __construct()
    {
        
    }

}
