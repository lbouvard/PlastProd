<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockRepository extends EntityRepository
{
	public function getListeStock()
	{

		/*
		SELECT s.NomSociete, p.CodeProduit, p.NomProduit, p.CategorieProduit, p.DescriptionProduit, p.PrixProduit, t.Produit_id, COUNT(t.Produit_id) FROM tabstock t 
		INNER JOIN tabproduits p ON t.Produit_id = p.IdtProduit
		INNER JOIN tabsociete s ON p.Producteur_id = s.IdtSociete
		WHERE t.bitSup = 0 GROUP BY Produit_id


		SELECT p.IdtProduit, p.CodeProduit, COUNT(t.Produit_id) FROM tabproduits p LEFT JOIN tabstock t ON p.IdtProduit = t.Produit_id WHERE p.bitSup = 0 GROUP BY p.IdtProduit
		*/

	    $qb = $this->createQueryBuilder('s')
	   		->Join('s.produit', 'prod')
	    	->addSelect('prod.codeProduit')
	    	->addSelect('prod.nomProduit')
	    	->addSelect('prod.categorieProduit')
	    	->addSelect('prod.descriptionProduit')
	    	->addSelect('prod.prixProduit')
	    	->Join('prod.producteur', 'fournisseur')
	    	->addSelect('fournisseur.nomSociete')
	    	->addSelect('COUNT(s.produit) AS quantite')
	    	->where('s.bitSup = :faux')
	    	->groupBy('s.produit')
	    	->setParameters(array('faux' => 0));

	    return $qb
	   		->getQuery()
	   		->getResult();
	}

	/*
	SELECT IdtEntree FROM tabstock WHERE Produit_id = 1 AND BitSup = 0 AND BitChg  = 0 ORDER BY DateEntree ASC LIMIT n
	*/
	public function getLigneASupprimer($limit, $id)
	{
		$qb = $this->createQueryBuilder('s')
			->where('s.bitSup = :faux')
			->andWhere('s.produit = :id')
			->orderBy('s.dateEntree', 'ASC')
			->setMaxResults( $limit )
			->setParameters(array('faux' => 0, 'id' => $id));

		return $qb
			->getQuery()
			->getResult();
	}

	public function getLignesParId($id)
	{
		$qb = $this->createQueryBuilder('s')
			->andWhere('s.produit = :id')
			->orderBy('s.dateEntree', 'ASC')
			->setParameters(array('id' => $id));

		return $qb
			->getQuery()
			->getResult();
	}

	public function getLigneStock($id)
	{	
		$qb = $this->createQueryBuilder('s')
	   		->leftJoin('s.produit', 'p')
	    	->addSelect('p')
			->where('s.idtEntree = :id')
			->setParameters(array('id'=> $id));

		return $qb
			->getQuery()
			->getSingleResult();
	}
}
