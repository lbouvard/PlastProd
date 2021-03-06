<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SocieteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SocieteRepository extends EntityRepository
{
	public function getListeClient()
	{
	  return $this
		->createQueryBuilder('s')
	    ->where('s.typeSociete = :type')
	    ->setParameters(array('type'=> 'C'));
	}

	public function getListeFournisseur()
	{
		return $this
			->createQueryBuilder('s')
	    	->where('s.typeSociete = :type')
	    	->setParameters(array('type'=> 'F'));	
	}

	public function getListeFournisseur2()
	{
		return $this
			->createQueryBuilder('s')
	    	->where('s.typeSociete = :type')
	    	->setParameters(array('type'=> 'F'))
	    	->getQuery()
	    	->getResult();	
	}	

	public function getListeFournisseurStock()
	{
		return $this
			->createQueryBuilder('s')
	    	->where('s.typeSociete = :type1')
	    	->orWhere('s.typeSociete = :type2')
	    	->setParameters(array('type1'=> 'F', 'type2' => 'M'));			
	}

	public function getSocieteParId($id)
	{
		$qb = $this->createQueryBuilder('s')
			->where('s.idtSociete = :id')
			->setParameters(array('id' => $id));

		return $qb->getQuery()
			->getSingleResult();
	}

	public function getSocieteMere()
	{
	  return $this
	    ->createQueryBuilder('s')
	    ->where('s.typeSociete = :type')
	    ->setParameters(array('type'=> 'M'))
	    ->getQuery()
	    ->getSingleResult();
	}

	public function getListeAccesCompte()
	{
		return $this
			->createQueryBuilder('s')
			->where('s.typeSociete = :client OR s.typeSociete = :plast')
			->setParameters(array('client' => 'C', 'plast' => 'M'))
			->getQuery()
			->getResult();
	}

	public function getListeCompteForm()
	{
		return $this
			->createQueryBuilder('s')
			->where('s.typeSociete = :client OR s.typeSociete = :plast')
			->setParameters(array('client' => 'C', 'plast' => 'M'));
	}
}
