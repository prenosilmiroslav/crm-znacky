<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\Brand;
use App\Models\User;

final class DashboardPresenter extends BasePresenter
{

    /** @var Brand $brandModel @inject */
    public Brand $brandModel;

    /** @var User $userModel @inject */
    public User $userModel;


    public function renderDefault()
    {
        $this->template->brandCount = $this->brandModel->getCount();
        $this->template->userCount = $this->userModel->getCount();
    }

}
