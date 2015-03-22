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
      array('Acces clients', 'ROLE_LEC_CLIENT'),
      array('Acces stock', 'ROLE_LEC_STOCK'),
      array('Acces production', 'ROLE_LEC_PRODUCTION'),
      array('Gestion clients', 'ROLE_GES_CLIENT'),
      array('Gestion stock', 'ROLE_GES_STOCK'),
      array('Gestion production', 'ROLE_GES_PRODUCTION'),
      array('Gestion configuration', 'ROLE_GES_CONFIG'),
      array('Accès local', 'ROLE_SEDENTAIRE'),
      array('Accès itinérant', 'ROLE_ITINERANT'),
      array('Administrateur', 'ROLE_ADMIN'),
      array('Direction', 'ROLE_DIRECTION'),
      array('Qualité', 'ROLE_QUALITE'), 
      array('Commercial', 'ROLE_COMMERCIAL'),
      array('Client', 'ROLE_CLIENT')        
    );

    foreach ($valeur as $ligne) {

      // On crée la société
      $role = new Role();
  
      $role->setNom($ligne[0]);
      $role->setRole($ligne[1]);

      // On la persiste
      $manager->persist($role);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 1; // l'ordre dans lequel les fichiers sont chargés
  }
}