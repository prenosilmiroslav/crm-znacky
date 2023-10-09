<?php

namespace App\Components\LoginForm;

interface ILoginFormFactory
{

    /** @return LoginForm */
    public function create(): LoginForm;

}
