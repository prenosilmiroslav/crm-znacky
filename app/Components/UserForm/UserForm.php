<?php

namespace App\Components\UserForm;

use App\Models\User;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class UserForm extends Control
{

    /** @var User $userModel */
    private User $userModel;


    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/UserForm.latte');
        $this->template->render();
    }

    protected function createComponentForm()
    {
        $form = new Form();

        $form->addHidden('user_id');

        $form->addText('username', 'Username')
            ->setRequired('Pole %label je povinné');

        $form->addPassword('password_check', 'Ověření hesla');
        $form->addPassword('password', 'Heslo')
            ->addRule(Form::MinLength, 'Heslo musí obsahovat alespoň 8 znaků.', 8)
            ->addRule(Form::Equal, 'Hesla se musí shodovat.', $form['password_check'])
            ->addConditionOn($form['user_id'], Form::Equal, '')
                ->setRequired('Pole %label je povinné');

        $form->addSubmit('_save', 'Uložit')
            ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = function (Form $form, ArrayHash $values)
        {
            $data = $this->userModel->getByUsername($values->username);
            if ($data)
            {
                $this->presenter->flashMessage('Zadaný uživatel již existuje', 'danger');
                $this->presenter->redirect('this');
            }

            $this->userModel->save($values, empty($values->user_id) && !is_int($values->user_id) ? NULL : $values->user_id);

            $this->presenter->flashMessage('Uživatel úspěšně uložen', 'success');
            $this->presenter->redirect('this');
        };

        return $form;
    }

}
