<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListeCauseRebu
 *
 * @ORM\Table(name="TABListeCauseRebu")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ListeCauseRebuRepository")
 */
class ListeCauseRebu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtCause", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtCause;

    /**
     * @var string
     *
     * @ORM\Column(name="NomRebu", type="string", length=25)
     */
    private $nomRebu;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtCause()
    {
        return $this->idtCause;
    }

    /**
     * Set nomRebu
     *
     * @param string $libelle
     * @return ListeCauseRebu
     */
    public function setNomRebu($libelle)
    {
        $this->nomRebu = $libelle;

        return $this;
    }

    /**
     * Get nomRebu
     *
     * @return string 
     */
    public function getNomRebu()
    {
        return $this->nomRebu;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ListeCauseRebu
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
}
