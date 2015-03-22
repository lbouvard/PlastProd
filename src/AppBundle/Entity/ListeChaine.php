<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListeChaine
 *
 * @ORM\Table(name="TABListeChaine")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ListeChaineRepository")
 */
class ListeChaine
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtChaine", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtChaine;

    /**
     * @var string
     *
     * @ORM\Column(name="NomChaine", type="string", length=25)
     */
    private $nomChaine;

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
    public function getIdtChaine()
    {
        return $this->idtChaine;
    }

    /**
     * Set nomChaine
     *
     * @param string $nomChaine
     * @return ListeChaine
     */
    public function setNomChaine($nomChaine)
    {
        $this->nomChaine = $nomChaine;

        return $this;
    }

    /**
     * Get nomChaine
     *
     * @return string 
     */
    public function getNomChaine()
    {
        return $this->nomChaine;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ListeChaine
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
