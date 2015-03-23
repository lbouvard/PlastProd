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
        array('RE1520820150323083014', new \DateTime('2015-03-23 13:26:03.000000'), new \DateTime('2015-03-23 13:41:03.000000'), 0, 1, null, 0, 2, 2, 7, null),
        array('RE1520820150323083014', new \DateTime('2015-03-23 09:01:45.000000'), null, 0, 0, new \DateTime('2015-03-23 10:05:30.000000'), 1, 2, 2, 1, null),
        array('RE1520820150323083014', new \DateTime('2015-03-23 10:07:30.000000'), null, 0, 0, new \DateTime('2015-03-23 11:02:10.000000'), 1, 2, 2, 2, null),
        array('RE1520820150323083014', new \DateTime('2015-03-23 11:09:10.000000'), null, 0, 0, new \DateTime('2015-03-23 12:14:18.000000'), 1, 2, 2, 3, null),
        array('RE1520820150323083014', new \DateTime('2015-03-23 12:17:18.000000'), null, 0, 0, new \DateTime('2015-03-23 13:01:37.000000'), 1, 2, 2, 4, null),
        array('RE1520820150323083014', new \DateTime('2015-03-23 13:04:37.000000'), null, 0, 0, new \DateTime('2015-03-23 13:26:03.000000'), 1, 2, 2, 6, null),
        array('PE1454220150320124510', new \DateTime('2015-03-20 13:32:47.000000'), new \DateTime('2015-03-20 13:40:48.000000'), 1, 1, null, 0, 3, 3, 5, 2),
        array('PE1454220150320124510', new \DateTime('2015-03-20 12:50:41.000000'), null, 0, 0, new \DateTime('2015-03-20 13:20:46.000000'), 1, 3, 3, 1, null),
        array('PE1454220150320124510', new \DateTime('2015-03-20 13:24:46.000000'), null, 0, 0, new \DateTime('2015-03-20 13:31:12.000000'), 1, 3, 3, 2, null),
        array('PE1454220150323174510', new \DateTime('2015-03-23 20:17:48.000000'), null, 0, 0, null, 0, 3, 3, 3, null),
        array('PE1454220150323174510', new \DateTime('2015-03-23 18:01:22.000000'), null, 0, 0, new \DateTime('2015-03-23 19:05:19.000000'), 1, 3, 3, 1, null),
        array('PE1454220150323174510', new \DateTime('2015-03-23 19:06:19.000000'), null, 0, 0, new \DateTime('2015-03-23 20:15:48.000000'), 1, 3, 3, 2, null),
        array('RE1520820150323181533', new \DateTime('2015-03-23 22:30:58.000000'), null, 0, 0, null, 0, 2, 2, 6, null),
        array('RE1520820150323181533', new \DateTime('2015-03-23 18:26:47.000000'), null, 0, 0, new \DateTime('2015-03-23 19:15:32.000000'), 1, 2, 2, 1, null),
        array('RE1520820150323181533', new \DateTime('2015-03-23 19:20:14.000000'), null, 0, 0, new \DateTime('2015-03-23 20:25:47.000000'), 1, 2, 2, 2, null),
        array('RE1520820150323181533', new \DateTime('2015-03-23 20:28:01.000000'), null, 0, 0, new \DateTime('2015-03-23 21:30:10.000000'), 1, 2, 2, 3, null),
        array('RE1520820150323181533', new \DateTime('2015-03-23 21:35:06.000000'), null, 0, 0, new \DateTime('2015-03-23 22:26:37.000000'), 1, 2, 2, 4, null),
        array('FD1363320150323191025', new \DateTime('2015-03-23 21:12:47.000000'), null, 1, 0, null, 0, 4, 4, 5, 1),
        array('FD1363320150323191025', new \DateTime('2015-03-23 19:15:10.000000'), null, 0, 0, new \DateTime('2015-03-23 19:41:24.000000'), 1, 4, 4, 1, null),
        array('FD1363320150323191025', new \DateTime('2015-03-23 19:45:21.000000'), null, 0, 0, new \DateTime('2015-03-23 20:36:41.000000'), 1, 4, 4, 3, null),
        array('FD1363320150323191025', new \DateTime('2015-03-23 20:40:13.000000'), null, 0, 0, new \DateTime('2015-03-23 21:10:45.000000'), 1, 4, 4, 3, null)
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
      $production->setChaine($this->getReference('chaine_'.$ligne[8]));
      $production->setEtat($this->getReference('etat_'.$ligne[9]));

      if( $ligne[10] != null )
        $production->setCauseRebu($this->getReference('rebu_'.$ligne[10]));
      else
        $production->setCauseRebu(null);
  
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