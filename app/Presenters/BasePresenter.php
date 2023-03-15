<?php

namespace App\Presenters;


use Nette;
use App\Repository\TeamsRepository;
use App\Repository\PersonsRepository;

/**
* BasePresenter
*
* @author hydroxid
* @see www.up4.cz
*/
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
    * @inject
    * @var TeamsRepository */
    public $teamsRepository;

    /**
    * @inject
    * @var PersonsRepository */
    public $personsRepository;

    /** @var Nette\Database\Context */
    protected $db;

    public function __construct(Nette\Database\Context $db)
    {
        $this->db = $db;
    }
}
