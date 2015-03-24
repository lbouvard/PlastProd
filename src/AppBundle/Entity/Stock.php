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
     * @var integer
     *
     * @ORM\Column(name="Quantite", type="integer")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="text", nullable=true)
     */
    private $commentaire;

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
     * @var \DateTime
     *
     * @ORM\Column(name="DateChg", type="datetime", nullable=true)
     */
    private $dateChg;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitChg", type="boolean")
     */
    private $bitChg;

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
		$this->bitChg = 0;
		$this->bitSup = 0;
        $this->dateChg = null;
        $this->dateSortie = null;
        $this->commentaire = null;
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
     * Set quantite
     *
     * @param integer $quantite
     * @return Stock
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Stock
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
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
     * Set dateChg
     *
     * @param \DateTime $dateChg
     * @return Stock
     */
    public function setDateChg($dateChg)
    {
        $this->dateChg = $dateChg;

        return $this;
    }

    /**
     * Get dateChg
     *
     * @return \DateTime 
     */
    public function getDateChg()
    {
        return $this->dateChg;
    }

    /**
     * Set bitChg
     *
     * @param boolean $bitChg
     * @return Stock
     */
    public function setBitChg($bitChg)
    {
        $this->bitChg = $bitChg;

        return $this;
    }

    /**
     * Get bitChg
     *
     * @return boolean 
     */
    public function getBitChg()
    {
        return $this->bitChg;
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
