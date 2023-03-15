<?php

namespace App\Repository;

use Nette;


/**
* TeamsRepository
*
* @author hydroxid
* @see www.up4.cz
*/
class TeamsRepository
{
  	use Nette\SmartObject;

  	/**
    * @var Nette\Database\Explorer
    */
  	private $db;

  	public function __construct(Nette\Database\Explorer $db)
  	{
  		  $this->db = $db;
  	}

    /**
    * find one team
    *
    * @param int $t_id team id
    * @author hydroxid
    */
    public function findOne(int $t_id) : ?Nette\Database\Table\ActiveRow
    {
        return $this->db->table('teams')
        ->where('t_id', $t_id)
        ->fetch();
    }

    /**
    * find all teams
    *
    * @param string $order order
    * @author hydroxid
    */
    public function findAll(string $order = 't_name ASC') : Nette\Database\Table\Selection
    {
        return $this->db->table('teams')
        ->order($order);
    }
}
