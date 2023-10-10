<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;
use Nette\SmartObject;

class BaseModel
{

    use SmartObject;

    /** @var Explorer $database */
    protected $database;

    /** @var string[] $allowSort Povolené řazení */
    protected $allowSort = ['ASC', 'DESC'];


    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

}
