<?php

namespace App\Repository;

use Nette;


/**
* PersonsRepository
*
* @author hydroxid
* @see www.up4.cz
*/
class PersonsRepository
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
    * find all persons
    *
    * @param string $order order
    * @author hydroxid
    */
    public function findAll(string $order = 'p_surname ASC') : Nette\Database\Table\Selection
    {
        return $this->db->table('persons')
        ->order($order);
    }

    /**
    * find all persons by type
    *
    * @param string $p_type p_type
    * @param string $order order
    * @author hydroxid
    */
    public function findAllByType(string $p_type, string $order = 'p_id ASC') : array
    {
        return $this->db->table('persons')
        ->select('p_id, p_surname')
        ->where('p_type', $p_type)
        ->order('p_surname ASC')
        ->fetchPairs('p_id', 'p_surname');
    }
}
