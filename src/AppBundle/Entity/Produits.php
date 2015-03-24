<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="TABProduits")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProduitsRepository")
 */
class Produits
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtProduit", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="NomProduit", type="string", length=50)
     */
    private $nomProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionProduit", type="text", nullable=true)
     */
    private $descriptionProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="CategorieProduit", type="string", length=50)
     */
    private $categorieProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeProduit", type="string", length=25, nullable=true)
     */
    private $codeProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixProduit", type="float")
     */
    private $prixProduit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateModif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitModif", type="boolean")
     */
    private $bitModif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitSup", type="boolean")
     */
    private $bitSup;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Societe")
    * @ORM\JoinColumn(nullable=false, name="Producteur_id", referencedColumnName="IdtSociete")
    */
    private $producteur;

    private $quantite;

    //constructeur
    public function __construct()
    {
        $this->dateModif = null;
        $this->bitModif  = 0;
        $this->bitSup    = 0;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtProduit()
    {
        return $this->idtProduit;
    }

    /**
     * Set nomProduit
     *
     * @param string $nomProduit
     * @return Produits
     */
    public function setNomProduit($nomProduit)
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    /**
     * Get nomProduit
     *
     * @return string 
     */
    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    /**
     * Set descriptionProduit
     *
     * @param string $descriptionProduit
     * @return Produits
     */
    public function setDescriptionProduit($descriptionProduit)
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    /**
     * Get descriptionProduit
     *
     * @return string 
     */
    public function getDescriptionProduit()
    {
        return $this->descriptionProduit;
    }

    /**
     * Set categorieProduit
     *
     * @param string $categorieProduit
     * @return Produits
     */
    public function setCategorieProduit($categorieProduit)
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }

    /**
     * Get categorieProduit
     *
     * @return string 
     */
    public function getCategorieProduit()
    {
        return $this->categorieProduit;
    }

    /**
     * Set codeProduit
     *
     * @param string $codeProduit
     * @return Produits
     */
    public function setCodeProduit($codeProduit)
    {
        $this->codeProduit = $codeProduit;

        return $this;
    }

    /**
     * Get codeProduit
     *
     * @return string 
     */
    public function getCodeProduit()
    {
        return $this->codeProduit;
    }

    /**
     * Set prixProduit
     *
     * @param float $prixProduit
     * @return Produits
     */
    public function setPrixProduit($prixProduit)
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    /**
     * Get prixProduit
     *
     * @return float 
     */
    public function getPrixProduit()
    {
        return $this->prixProduit;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return Produits
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime 
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set bitModif
     *
     * @param boolean $bitModif
     * @return Produits
     */
    public function setBitModif($bitModif)
    {
        $this->bitModif = $bitModif;

        return $this;
    }

    /**
     * Get bitModif
     *
     * @return boolean 
     */
    public function getBitModif()
    {
        return $this->bitModif;
    }

    /**
     * Set bitSup
     *
     * @param boolean $bitSup
     * @return Produits
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

    public function setProducteur(Societe $societe)
    {
        $this->producteur = $societe;

        return $this;
    }

    public function getProducteur()
    {
        return $this->producteur;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }
}
