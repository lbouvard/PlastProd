<?php
// src/AppBundle/DataFixtures/ORM/LoadRole.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Acces clients', 'ROLE_LEC_CLIENT', 'Avancée'),
      array('Acces stock', 'ROLE_LEC_STOCK', 'Avancée'),
      array('Acces production', 'ROLE_LEC_PRODUCTION', 'Avancée'),
      array('Gestion clients', 'ROLE_GES_CLIENT', 'Avancée'),
      array('Gestion stock', 'ROLE_GES_STOCK', 'Avancée'),
      array('Gestion production', 'ROLE_GES_PRODUCTION', 'Avancée'),
      array('Gestion configuration', 'ROLE_GES_CONFIG', 'Avancée'),
      array('Accès local', 'ROLE_SEDENTAIRE', 'Accès'),
      array('Accès itinérant', 'ROLE_ITINERANT', 'Accès'),
      array('Administrateur', 'ROLE_ADMIN', 'Utilisateur'),
      array('Direction', 'ROLE_DIRECTION', 'Utilisateur'),
      array('Qualité', 'ROLE_QUALITE', 'Utilisateur'), 
      array('Commercial', 'ROLE_COMMERCIAL', 'Utilisateur'),
      array('Client', 'ROLE_CLIENT', 'Utilisateur'),
      array('Gestion contact', 'ROLE_GES_CONTACT', 'Avancée'),
      array('Accès contact', 'ROLE_LEC_CONTACT', 'Avancée')     
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $role = new Role();
  
      $role->setNom($ligne[0]);
      $role->setRole($ligne[1]);
      $role->setCategorie($ligne[2]);

      // On la persiste
      $manager->persist($role);

      $this->addReference('role_'.$i++, $role);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 5; // l'ordre dans lequel les fichiers sont chargés
  }
}