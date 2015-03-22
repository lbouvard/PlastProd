<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commande
 *
 * @ORM\Table(name="TABCommande")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommandeRepository")
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtCommande", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCommande", type="datetime", nullable=true)
     */
    private $dateCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="EtatCommande", type="string", length=50)
     */
    private $etatCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="text", nullable=true)
     */
    private $commentaire;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Contact")
     * @ORM\JoinColumn(nullable=false, name="Contact_id", referencedColumnName="IdtContact")
     */
    private $commercial;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Societe")
    * @ORM\JoinColumn(nullable=false, name="Societe_id", referencedColumnName="IdtSociete")
    */
    private $client;

    /*
    * @ORM\OneToMany(targetEntity="CommandeProduits" mappedBy="commande", cascade={"persist", "remove"})
    */
    protected $produits;
    

    public function __construct() 
    {
        $this->dateCommande = new \datetime();
        $this->etatCommande = "Validée";
        $this->commentaire = "";
        $this->dateChg = null;
        $this->bitChg = 0;
        $this->bitSup = 0;


        $this->produits = new ArrayCollection();
    }

    public function setProduits(ArrayCollection $produits)
    {
        foreach ($produits->toArray() as $commandeproduits) {
            # code...
            $this->produits->add($commandeproduits);
        }
        
    }

    public function getProduits()
    {
        return $this->produits;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set montant
     *
     * @param float $montant
     * @return Commande
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set dateCommande
     *
     * @param \DateTime $dateCommande
     * @return Commande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * Get dateCommande
     *
     * @return \DateTime 
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Set etatCommande
     *
     * @param string $etatCommande
     * @return Commande
     */
    public function setEtatCommande($etatCommande)
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    /**
     * Get etatCommande
     *
     * @return string 
     */
    public function getEtatCommande()
    {
        return $this->etatCommande;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Commande
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
     * Set dateChg
     *
     * @param \DateTime $dateChg
     * @return Commande
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
     * @return Commande
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
     * @return Commande
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

    public function setCommercial(Contact $contact)
    {
        $this->commercial = $contact;

        return $this;
    }

    public function getCommercial()
    {
        return $this->commercial;
    }

    public function setClient(Societe $societe)
    {
        $this->client = $societe;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }
}
