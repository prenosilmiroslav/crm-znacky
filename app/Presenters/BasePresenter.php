<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\PageHeader\IPageHeaderFactory;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{

    /** @var IPageHeaderFactory $pageHeaderFactory @inject */
    public $pageHeaderFactory;


    public function startup()
    {
        if (!$this->getUser()->isLoggedIn() && $this->presenter->name !== 'Login' && $this->presenter->action != 'login')
        {
            $this->redirect('Login:login');
        }

        parent::startup();
    }

    protected function createComponentPageHeader()
    {
        return $this->pageHeaderFactory->create();
    }

}
