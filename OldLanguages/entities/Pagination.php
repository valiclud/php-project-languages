<?php


namespace entities;

class Pagination
{

    public $id;

    public $controller_name;

    public $results;

    public static function default(): self
    {
        return self::from(0, "", 5);
    }

    public static function from(int $id, String $controller_name, int $results): self
    {
        $instance = new self();
        $instance->id        = $id;
        $instance->controller_name     = $controller_name;
        $instance->results   = $results;

        return $instance;
    }

    private function __construct()
    {
    }
}
