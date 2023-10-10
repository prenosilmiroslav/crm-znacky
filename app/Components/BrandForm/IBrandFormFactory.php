<?php

namespace App\Components\BrandForm;

interface IBrandFormFactory
{

    /** @return BrandForm */
    public function create(): BrandForm;

}
