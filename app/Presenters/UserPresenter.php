<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\UserForm\IUserFormFactory;
use App\Components\UserForm\UserForm;
use App\Models\Parameters;
use App\Models\User;
use Nette\Utils\Paginator;
use Nette\Utils\Validators;

final class UserPresenter extends BasePresenter
{

    /** @var User $userModel @inject */
    public User $userModel;

    /** @var Parameters $parametersModel @inject */
    public Parameters $parametersModel;

    /** @var IUserFormFactory $userFormFactory @inject */
    public IUserFormFactory $userFormFactory;

    /** @var int $itemForCount @persistent */
    public int $itemForCount;

    /** @var string $order @persistent */
    public string $order;

    /** @var string $by @persistent */
    public string $by;


    public function renderDefault()
    {
        $params = $this->request->parameters;

        $itemForPageList = $this->parametersModel->get('itemForPageList');

        // Výběr stránky a validace hodnoty
        $page = 1;
        if (!empty($params['page']) && $params['page'] > 0 && Validators::is($params['page'], 'int'))
        {
            $page = (int) $params['page'];
        }

        // Počet položek na stránku musí odpovídat zadanému seznamu hodnot v configu
        $itemForCount = $itemForPageList[0];
        if (!empty($this->itemForCount) && Validators::is($this->itemForCount, 'int') && in_array($this->itemForCount, $itemForPageList))
        {
            $itemForCount = (int) $this->itemForCount;
        }

        $paginator = new Paginator();
        $paginator->setPage($page);
        $paginator->setItemsPerPage($itemForCount);
        $paginator->setItemCount($this->userModel->getCount($params));

        $this->template->list = $this->userModel->getAll($params, $paginator->getLength(), $paginator->getOffset());
        $this->template->itemForPageList = $itemForPageList;
        $this->template->paginator = $paginator;
        $this->template->actualPage = $page;
    }

    /**
     * Vrací data pro editační formulář
     *
     * @return void
     * @throws \Nette\Application\AbortException
     */
    public function actionGetData()
    {
        $params = $this->request->parameters;

        if (!empty($params['userId']))
        {
            $data = $this->userModel->get((int) $params['userId']);

            if (!empty($data))
            {
                $this->sendJson([
                    'success' => TRUE,
                    'data' => $data->toArray(),
                ]);
            }
        }

        $this->sendJson(['success' => FALSE]);
    }

    /**
     * Maže konkrétní záznam z databáze
     *
     * @return void
     * @throws \Nette\Application\AbortException
     */
    public function actionDelete()
    {
        $post = $this->request->post;

        if (!empty($post['userId']))
        {
            $this->userModel->remove((int) $post['userId']);
            $this->sendJson(['success' => TRUE]);
        }

        $this->sendJson(['success' => FALSE]);
    }

    protected function createComponentUserForm(): UserForm
    {
        return $this->userFormFactory->create();
    }

}
