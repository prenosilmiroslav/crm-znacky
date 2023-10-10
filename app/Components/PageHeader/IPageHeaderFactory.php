<?php

namespace App\Components\PageHeader;

interface IPageHeaderFactory
{

    /** @return PageHeader */
    public function create(): PageHeader;

}
