<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;

class Parameters extends BaseModel
{

    /** @var array $parameters */
    private $parameters;


    public function __construct(Explorer $database, array $parameters)
    {
        parent::__construct($database);
        $this->parameters = $parameters;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed
    {
        if (!empty($name) && isset($this->parameters[$name]))
        {
            return $this->parameters[$name];
        }

        return NULL;
    }

}
