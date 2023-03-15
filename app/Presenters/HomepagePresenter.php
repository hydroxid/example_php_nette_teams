<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends BasePresenter
{
    /**
    * default (index)
    *
    * @return void
    * @author hydroxid
    */
    public function renderDefault() : void
    {
        // find all teams
        $this->template->rows = $this->teamsRepository->findAll();
    }
}
