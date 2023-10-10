<?php

namespace App\Presenters;

use App\Components\BrandForm\BrandForm;
use App\Components\BrandForm\IBrandFormFactory;
use App\Models\Brand;
use App\Models\Parameters;
use App\Presenters\BasePresenter;
use Nette\Utils\Paginator;
use Nette\Utils\Validators;

class BrandPresenter extends BasePresenter
{

    /** @var Brand $brandModel @inject */
    public Brand $brandModel;

    /** @var Parameters $parametersModel @inject */
    public Parameters $parametersModel;

    /** @var IBrandFormFactory $brandFormFactory @inject */
    public IBrandFormFactory $brandFormFactory;

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
        $paginator->setItemCount($this->brandModel->getCount($params));

        $this->template->list = $this->brandModel->getAll($params, $paginator->getLength(), $paginator->getOffset());
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

    /**
     * Maže konkrétní záznam z databáze
     *
     * @return void
     * @throws \Nette\Application\AbortException
     */
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

    protected function createComponentBrandForm(): BrandForm
    {
        return $this->brandFormFactory->create();
    }

}
