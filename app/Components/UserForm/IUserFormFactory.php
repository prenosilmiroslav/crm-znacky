<?php

namespace App\Components\UserForm;

interface IUserFormFactory
{

    /** @return UserForm */
    public function create(): UserForm;

}
