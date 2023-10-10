<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\UserForm\IUserFormFactory;
use App\Components\UserForm\UserForm;
use App\Models\Parameters;
use App\Models\User;
use Nette\Utils\Paginator;

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

        $page = 1;
        if (!empty($params['page']))
        {
            $page = (int) $params['page'];
        }

        $paginator = new Paginator();
        $paginator->setPage($page);
        $paginator->setItemsPerPage(empty($this->itemForCount) ? $itemForPageList[0] : (int) $this->itemForCount);
        $paginator->setItemCount($this->userModel->getCount($params));

        $this->template->list = $this->userModel->getAll($params, $paginator->getLength(), $paginator->getOffset());
        $this->template->itemForPageList = $itemForPageList;
        $this->template->paginator = $paginator;
        $this->template->actualPage = $page;
    }

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
