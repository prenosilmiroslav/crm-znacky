<?php

namespace App\Components\BrandForm;

use App\Models\Brand;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class BrandForm extends Control
{

    /** @var Brand $brandModel */
    private Brand $brandModel;


    public function __construct(Brand $brand)
    {
        $this->brandModel = $brand;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/BrandForm.latte');
        $this->template->render();
    }

    protected function createComponentForm()
    {
        $form = new Form();

        $form->addHidden('brand_id');

        $form->addText('name', 'Název značky')
            ->setRequired('Pole %label je povinné');

        $form->addSubmit('_save', 'Uložit')
            ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = function (Form $form, ArrayHash $values)
        {
            $data = $this->brandModel->getByName($values->name);
            if ($data)
            {
                $this->presenter->flashMessage('Zadná značka již existuje', 'danger');
                $this->presenter->redirect('this');
            }

            $values->user_id = $this->presenter->getUser()->getId();

            $this->brandModel->save($values, empty($values->brand_id) && !is_int($values->brand_id) ? NULL : $values->brand_id);

            $this->presenter->flashMessage('Značka úspěšně uložena', 'success');
            $this->presenter->redirect('this');
        };

        return $form;
    }

}
