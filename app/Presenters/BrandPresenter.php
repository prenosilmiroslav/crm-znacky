<?php

namespace App\Presenters;

use App\Components\BrandForm\IBrandFormFactory;
use App\Models\Brand;
use App\Models\Parameters;
use App\Presenters\BasePresenter;
use Nette\Utils\Paginator;

class BrandPresenter extends BasePresenter
{

    /** @var Brand $brandModel @inject */
    public $brandModel;

    /** @var Parameters $parametersModel @inject */
    public $parametersModel;

    /** @var IBrandFormFactory $brandFormFactory @inject */
    public $brandFormFactory;

    /** @var int $itemForCount @persistent */
    public $itemForCount;

    /** @var string $order @persistent */
    public $order;

    /** @var string $by @persistent */
    public $by;


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
        $paginator->setItemCount($this->brandModel->getCount($params));

        $this->template->list = $this->brandModel->getAll($params, $paginator->getLength(), $paginator->getOffset());
        $this->template->itemForPageList = $itemForPageList;
        $this->template->paginator = $paginator;
        $this->template->actualPage = $page;
    }

    public function actionGetData()
    {
        $params = $this->request->parameters;

        if (!empty($params['brandId']))
        {
            $data = $this->brandModel->get((int) $params['brandId']);

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

        if (!empty($post['brandId']))
        {
            $this->brandModel->remove((int) $post['brandId']);
            $this->sendJson(['success' => TRUE]);
        }

        $this->sendJson(['success' => FALSE]);
    }

    protected function createComponentBrandForm()
    {
        return $this->brandFormFactory->create();
    }

}
