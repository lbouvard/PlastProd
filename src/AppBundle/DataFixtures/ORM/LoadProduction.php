<?php
// src/AppBundle/DataFixtures/ORM/LoadProduction.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Production;
use AppBundle\Entity\ListeCauseRebu;
use AppBundle\Entity\ListeChaine;
use AppBundle\Entity\ListeEtat;

class LoadProduction extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('RE1520820150210', new \DateTime('2015-02-11 07:25:10'), null, 0, 0, null, 0, 1, 3, 1, 0),
      array('RE1520820150210', new \DateTime('2015-02-10 07:25:10'), new \DateTime('2015-02-10 14:26:15'), 0, 1, null, 0, 1, 1, 6, 0),
      array('RE1520820150210', new \DateTime('2015-02-11 06:25:00'), null, 0, 0, null, 0, 1, 0, 0, 0),
      array('RE1520820150210', new \DateTime('2015-02-11 06:25:00'), null, 1, 0, new \DateTime('2015-02-11 07:02:00'), 1, 1, 2, 3, 1),
      array('RE1520820150210', new \DateTime('2015-02-11 06:25:10'), new \DateTime('2015-02-11 07:10:55'), 1, 1, null, 0, 1, 4, 6, 2),
      array('PE1454220150124', new \DateTime('2015-01-25 06:00:41'), null, 0, 0, null, 0, 2, 3, 1, 0),
      array('PE1454220150124', new \DateTime('2015-01-25 06:00:41'), null, 0, 0, new \DateTime('2015-01-25 08:25:12'), 1, 2, 0, 2, 0),
      array('PE1454220150124', new \DateTime('2015-01-25 06:00:41'), new \DateTime('2015-01-25 12:20:45'), 0, 1, new \DateTime('2015-01-25 12:20:46'), 1, 2, 0, 6, 0),
      array('FD1363320150217', new \DateTime('2015-01-18 08:25:00'), null, 0, 0, null, 0, 3, 0, 0, 0)
    );

    foreach ($valeur as $ligne) {

      // On crée la société
      $production = new Production();
  
      $production->setCodeInterne($ligne[0]);
      $production->setDateDebut($ligne[1]);
      $production->setDateFin($ligne[2]);
      $production->setBitRebu($ligne[3]);
      $production->setBitFin($ligne[4]);
      $production->setDateModif($ligne[5]);
      $production->setBitModif($ligne[6]);
      $production->setProduit($this->getReference('produit_'.$ligne[7]));

      if( $ligne[8] > 0 )
        $production->setChaine($this->getReference('chaine_'.$ligne[8]));
      else
        $production->setChaine();

      if( $ligne[9] > 0 )  
        $production->setEtat($this->getReference('etat_'.$ligne[9]));
      else
        $production->setEtat();
      
      if( $ligne[10] > 0 )
        $production->setCauseRebu($this->getReference('rebu_'.$ligne[10]));
      else
        $production->setCauseRebu();
  
      // On la persiste
      $manager->persist($production);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 12; // l'ordre dans lequel les fichiers sont chargés
  }
}