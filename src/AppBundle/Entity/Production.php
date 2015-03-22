<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Production
 *
 * @ORM\Table(name="TABProduction")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductionRepository")
 */
class Production
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtElement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtElement;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeInterne", type="string", length=25)
     */
    private $codeInterne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitRebu", type="boolean")
     */
    private $bitRebu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BitFin", type="boolean")
     */
    private $bitFin;

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
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produits")
    * @ORM\JoinColumn(nullable=false, name="Produit_id", referencedColumnName="IdtProduit")
    */
    private $produit;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ListeChaine")
    * @ORM\JoinColumn(nullable=true, name="Chaine_id", referencedColumnName="IdtChaine")
    */
    private $chaine;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ListeEtat")
    * @ORM\JoinColumn(nullable=true, name="Etat_id", referencedColumnName="IdtEtat")
    */
    private $etat;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ListeCauseRebu")
    * @ORM\JoinColumn(nullable=true, name="Causerebu_id", referencedColumnName="IdtCause")
    */
    private $causeRebu;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtElement()
    {
        return $this->idtElement;
    }

    /**
     * Set codeInterne
     *
     * @param string $codeInterne
     * @return Production
     */
    public function setCodeInterne($codeInterne)
    {
        $this->codeInterne = $codeInterne;

        return $this;
    }

    /**
     * Get codeInterne
     *
     * @return string 
     */
    public function getCodeInterne()
    {
        return $this->codeInterne;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Production
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Production
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set bitRebu
     *
     * @param boolean $bitRebu
     * @return Production
     */
    public function setBitRebu($bitRebu)
    {
        $this->bitRebu = $bitRebu;

        return $this;
    }

    /**
     * Get bitRebu
     *
     * @return boolean 
     */
    public function getBitRebu()
    {
        return $this->bitRebu;
    }

    /**
     * Set bitFin
     *
     * @param boolean $bitFin
     * @return Production
     */
    public function setBitFin($bitFin)
    {
        $this->bitFin = $bitFin;

        return $this;
    }

    /**
     * Get bitFin
     *
     * @return boolean 
     */
    public function getBitFin()
    {
        return $this->bitFin;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return Production
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
     * @return Production
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


    public function setProduit(Produits $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    public function getProduit()
    {
        return $this->produit;
    }


    public function setChaine(ListeChaine $chaine = null)
    {
        $this->chaine = $chaine;

        return $this;
    }

    public function getChaine()
    {
        return $this->chaine;
    }


    public function setEtat(ListeEtat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setCauseRebu(ListeCauseRebu $cause = null)
    {
        $this->causeRebu = $cause;

        return $this;
    }

    public function getCauseRebu()
    {
        return $this->causeRebu;
    }
}
