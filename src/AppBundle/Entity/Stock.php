<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="TABStock")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\StockRepository")
 */
class Stock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtEntree", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtEntree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEntree", type="datetime", nullable=true)
     */
    private $dateEntree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateSortie", type="datetime", nullable=true)
     */
    private $dateSortie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitSup", type="boolean")
     */
    private $bitSup;

     /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produits")
    * @ORM\JoinColumn(nullable=false, name="Produit_id", referencedColumnName="IdtProduit")
    */
    private $produit;

    public function __construct() 
	{
		$this->bitSup = 0;
        $this->dateSortie = null;
	}
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtEntree()
    {
        return $this->idtEntree;
    }

    /**
     * Set dateEntree
     *
     * @param \DateTime $dateEntree
     * @return Stock
     */
    public function setDateEntree($dateEntree)
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    /**
     * Get dateEntree
     *
     * @return \DateTime 
     */
    public function getDateEntree()
    {
        return $this->dateEntree;
    }

    /**
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     * @return Stock
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime 
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set bitSup
     *
     * @param boolean $bitSup
     * @return Stock
     */
    public function setBitSup($bitSup)
    {
        $this->bitSup = $bitSup;

        return $this;
    }

    /**
     * Get bitSup
     *
     * @return boolean 
     */
    public function getBitSup()
    {
        return $this->bitSup;
    }

    public function setProduit(Produits $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    public function getProduit()
    {
        return $this->produit;
    }
}
