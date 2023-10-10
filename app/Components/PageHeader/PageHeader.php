<?php

namespace App\Components\PageHeader;

use App\Models\Parameters;
use Nette\Application\UI\Control;

class PageHeader extends Control
{

    /** @var array $pageHeaderParameters */
    private array $pageHeaderParameters;


    public function __construct(Parameters $parameters)
    {
        $this->pageHeaderParameters = $parameters->get('pageHeader');
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/PageHeader.latte');
        $this->template->pageHeader = $this->pageHeaderParameters[$this->presenter->name];
        $this->template->render();
    }

}
