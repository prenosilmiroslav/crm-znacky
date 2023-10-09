<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{

    public function startup()
    {
        if (!$this->getUser()->isLoggedIn() && $this->presenter->name !== 'Login' && $this->presenter->action != 'login')
        {
            $this->redirect('Login:login');
        }

        parent::startup();
    }

}
