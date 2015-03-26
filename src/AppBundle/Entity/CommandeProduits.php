<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CommandeProduits
 *
 * @ORM\Table(name="TABCommandeProduits")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommandeProduitsRepository")
 */
class CommandeProduits
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Idt", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idt;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeProduit", type="string", length=50)
     */
    private $codeProduit;

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
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantite", type="integer")
     * @Assert\Range(min=0, max=9999)
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixProduit", type="float")
     */
    private $prixProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixTotal", type="float")
     */
    private $prixTotal;

    /**
    * @ORM\ManyToOne(targetEntity="Commande", inversedBy="produits", cascade={"persist"})
    * @ORM\JoinColumn(name="commande_id", referencedColumnName="IdtCommande")
    */
    protected $commande;

    /**
     * Get idt
     *
     * @return integer 
     */
    public function getIdt()
    {
        return $this->idt;
    }

    /**
     * Set codeProduit
     *
     * @param string $codeProduit
     * @return CommandeProduits
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
     * Set nomProduit
     *
     * @param string $nomProduit
     * @return CommandeProduits
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
     * Set description
     *
     * @param string $description
     * @return CommandeProduits
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return CommandeProduits
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
     * Set prixProduit
     *
     * @param float $prixProduit
     * @return CommandeProduits
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
     * Set prixTotal
     *
     * @param float $prixTotal
     * @return CommandeProduits
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return float 
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * Set commande
     *
     * @param \AppBundle\Entity\Commande $commande
     * @return CommandeProduits
     */
    public function setCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        //return $this;
    }

    /**
     * Get commande
     *
     * @return \AppBundle\Entity\Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }
}