<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Utilisateur
 *
 * @ORM\Table(name="TABUtilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UtilisateurRepository")
 */
class Utilisateur implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdtUtilisateur", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="MotDePasse", type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Salt", type="string", length=60)
     *
     */
    private $salt;

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
     * @ORM\Column(name="Actif", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="utilisateurs")
     * @ORM\JoinTable(name="TABUtilisateur_Role",
     *      joinColumns={@ORM\JoinColumn(name="utilisateur_id", referencedColumnName="IdtUtilisateur")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="IdtRole")}
     *      )
     */
    private $roles;

    private $mdpTemp;

    public function __construct()
    {
        //initialisation
        $this->dateModif = null;
        $this->bitModif = 0;
        $this->bitSup = 0;

        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));

        $this->roles = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return Utilisateur
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Utilisateur
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function setMdpTemp($mdptemp)
    {
        $this->mdpTemp = $mdptemp;

        return $this;
    }

    public function getMdpTemp()
    {
        return $this->mdpTemp;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return Utilisateur
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
     * @return Utilisateur
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
     * @return Utilisateur
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

    /**
     * Set isActive
     *
     * @param boolean $active
     * @return Utilisateur
     */
    public function setIsActive($active)
    {
        $this->isActive = $active;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function addRole(Role $role)
    {
        $this->roles->add($role);
        $role->addUtilisateur($this);
    }

    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
        $role->removeUtilisateur($this);
    }

    public function clearRoles()
    {
        $this->roles->clear();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ) = unserialize($serialized);
    }
}
