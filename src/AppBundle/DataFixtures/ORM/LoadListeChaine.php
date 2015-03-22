<?php
// src/AppBundle/DataFixtures/ORM/LoadListeChaine.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ListeChaine;

class LoadListeChaine extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Chaine1', 'Chaine d\'assemblage nord'),
      array('Chaine2', 'Chaine d\'assemblage sud'),
      array('Chaine3', 'Chaine d\'emboutissage'),
      array('Chaine4', 'Chaine de découpe'),
      array('ChaineRebu', 'Chaine finale de rebut')
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $liste = new ListeChaine();
  
      $liste->setNomChaine($ligne[0]);
      $liste->setDescription($ligne[1]);
  
      // On la persiste
      $manager->persist($liste);

      $this->addReference('chaine_'.$i++, $liste);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 7; // l'ordre dans lequel les fichiers sont chargés
  }
}