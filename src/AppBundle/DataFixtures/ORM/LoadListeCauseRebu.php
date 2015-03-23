<?php
// src/AppBundle/DataFixtures/ORM/LoadListeCauseRebu.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ListeCauseRebu;

class LoadListeCauseRebu extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Val1HS', 'Valeur 1 non conforme'),
      array('Val2HS', 'Valeur 2 non conforme'),
      array('Val3HS', 'Valeur 3 non conforme')
    );

    $i = 1;

    foreach ($valeur as $ligne) {

      // On crée la société
      $liste = new ListeCauseRebu();
  
      $liste->setNomRebu($ligne[0]);
      $liste->setDescription($ligne[1]);
  
      // On la persiste
      $manager->persist($liste);

      $this->addReference('rebu_'.$i++, $liste);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 1; // l'ordre dans lequel les fichiers sont chargés
  }
}