<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListeEtat
 *
 * @ORM\Table(name="TABListeEtat")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ListeEtatRepository")
 */
class ListeEtat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtEtat", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idtEtat;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEtat", type="string", length=50)
     */
    private $nomEtat;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="text")
     */
    private $commentaire;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdtEtat()
    {
        return $this->idtEtat;
    }

    /**
     * Set nomEtat
     *
     * @param string $libelle
     * @return ListeEtat
     */
    public function setNomEtat($libelle)
    {
        $this->nomEtat = $libelle;

        return $this;
    }

    /**
     * Get nomEtat
     *
     * @return string 
     */
    public function getNomEtat()
    {
        return $this->nomEtat;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return ListeEtat
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
}
