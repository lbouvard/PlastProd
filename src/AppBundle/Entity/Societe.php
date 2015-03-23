<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="TABSociete")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SocieteRepository")
 */
class Societe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtSociete", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="NomSociete", type="string", length=50)
     */
    private $nomSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse1", type="string", length=50)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse2", type="string", length=50, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=10)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=50)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=50)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeSociete", type="string", length=25)
     */
    private $typeSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="text", nullable=true)
     */
    private $commentaire;

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


    public function __construct($type)
    {
        $this->dateModif = null;
        $this->bitModif  = 0;
        $this->bitSup    = 0;
        $this->typeSociete = $type;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtSociete()
    {
        return $this->idtSociete;
    }

    /**
     * Set nomSociete
     *
     * @param string $nomSociete
     * @return Societe
     */
    public function setNomSociete($nomSociete)
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    /**
     * Get nomSociete
     *
     * @return string 
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     * @return Societe
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Get adresse1
     *
     * @return string 
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * Set adresse2
     *
     * @param string $adresse2
     * @return Societe
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2
     *
     * @return string 
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Societe
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Societe
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Societe
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set typeSociete
     *
     * @param string $typeSociete
     * @return Societe
     */
    public function setTypeSociete($typeSociete)
    {
        $this->typeSociete = $typeSociete;

        return $this;
    }

    /**
     * Get typeSociete
     *
     * @return string 
     */
    public function getTypeSociete()
    {
        return $this->typeSociete;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Societe
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
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return Societe
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
     * @return Societe
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
     * @return Societe
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
}
