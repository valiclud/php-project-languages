<?php

namespace entities;
class Author
{
    const EDIT_TEXT = 1;
    const DELETE_TEXT = 2;
    const SAVE_TEXT = 4; 
    const LIST_TEXT = 8;
    const EDIT_USER_ACCESS = 16;

    public $id;
    public $email;
    public $password;
    public $permission;

    public function __construct()
    {
    }

    public function hasPermission(int $permission) {
        var_dump(" I AM HERE -- ". $permission );
        return $this->permission & $permission;
    }

}
