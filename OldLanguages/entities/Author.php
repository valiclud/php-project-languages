<?php

namespace entities;
class Author
{
    const EDIT_JOKES = 1;
    const DELETE_JOKES = 2;
    const LIST_CATEGORIES = 4;
    const EDIT_CATEGORY = 8;
    const DELETE_CATEGORY = 16;
    const EDIT_USER_ACCESS = 32;

    public $id;
    public $email;
    public $password;

    public function __construct()
    {
    }
/*
    public function hasPermission(int $permission) {
        return $this->permissions & $permission;
    }
*/
}
