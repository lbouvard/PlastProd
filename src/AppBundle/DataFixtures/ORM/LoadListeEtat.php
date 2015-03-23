<?php
// src/AppBundle/DataFixtures/ORM/LoadListeEtat.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ListeEtat;

class LoadListeEtat extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Démarrage', 'Début de mise en production'),
      array('Etape1', 'Etape1'),
      array('Etape2', 'Etape2'),
      array('Etape3', 'Etape3'),
      array('Défaut', 'Défaut rencontré. Mise au rebut'),
      array('Finalisation', 'Etape de finalisation'),
      array('Produit fini', 'Produit fini et stocké')
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $liste = new ListeEtat();
  
      $liste->setNomEtat($ligne[0]);
      $liste->setCommentaire($ligne[1]);
  
      // On la persiste
      $manager->persist($liste);

      $this->addReference('etat_'.$i++, $liste);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 3; // l'ordre dans lequel les fichiers sont chargés
  }
}