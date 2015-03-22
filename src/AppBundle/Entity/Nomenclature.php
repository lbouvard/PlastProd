<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nomenclature
 *
 * @ORM\Table(name="TABNomenclature")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\NomenclatureRepository")
 */
class Nomenclature
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtNomenclature", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtNomenclature;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantite", type="integer")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeProduit", type="string", length=25)
     */
    private $codeProduit;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produits")
    * @ORM\JoinColumn(nullable=false, name="Produit_id", referencedColumnName="IdtProduit")
    */
    private $produit;
	
	private $nombre;
	
	public function getNombre()
	{
		return $this->nombre;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtNomenclature()
    {
        return $this->idtNomenclature;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Nomenclature
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
     * Set codeProduit
     *
     * @param string $codeProduit
     * @return Nomenclature
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
