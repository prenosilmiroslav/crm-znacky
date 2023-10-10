<?php

namespace App\Components\LoginForm;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;

class LoginForm extends Control
{

    public function render()
    {
        $this->template->setFile(__DIR__ . '/LoginForm.latte');
        $this->template->render();
    }

    protected function createComponentForm(): Form
    {
        $form = new Form();

        $form->addText('username', 'Username')
            ->setRequired('Pole %label je povinné.');

        $form->addPassword('password', 'Heslo')
            ->setRequired('Pole %label je povinné.');

        $form->addSubmit('_login', 'Přihlásit se')
            ->setHtmlAttribute('class', 'btn btn-submit');

        $form->onSuccess[] = function (Form $form, ArrayHash $values)
        {
            try
            {
                $this->presenter->getUser()->login($values->username, $values->password);
                $this->presenter->flashMessage('Uživatel úspěšně přihlášen', 'success');
                $this->presenter->redirect('Dashboard:default');
            }
            catch (AuthenticationException $exception)
            {
                $this->presenter->flashMessage($exception->getMessage(), 'danger');
            }
        };

        return $form;
    }

}
