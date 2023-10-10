<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\LoginForm\ILoginFormFactory;
use App\Presenters\BasePresenter;

final class LoginPresenter extends BasePresenter
{

    /** @var ILoginFormFactory $loginFormFactory @inject */
    public $loginFormFactory;


    public function renderLogin()
    {

    }

    public function actionLogout()
    {
        if ($this->getUser()->isLoggedIn())
        {
            $this->getUser()->logout(TRUE);
        }

        $this->flashMessage('Uživatel byl úspěšně odhlášen', 'success');
        $this->redirect('Login:login');
    }

    protected function createComponentLoginForm()
    {
        return $this->loginFormFactory->create();
    }

}
