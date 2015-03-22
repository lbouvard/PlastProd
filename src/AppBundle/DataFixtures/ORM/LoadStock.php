<?php
// src/AppBundle/DataFixtures/ORM/LoadStock.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Stock;

class LoadStock extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array(10, '', new \DateTime('2014-11-29 10:50:00'), null, null, 0, 0, 1),
      array('5', '', new \DateTime('2014-12-27 10:42:54'), null, null, 0, 0, 2),
      array('25', '', new \DateTime('2014-12-16 07:00:10'), null, null, 0, 0, 3),
      array('20', '', new \DateTime('2014-12-16 07:00:10'), new \DateTime('2014-12-20 14:12:00'), new \DateTime('2014-12-20 14:12:00'), 1, 0, 3),
      array('4', '', new \DateTime('2014-12-17 09:12:00'), null, null, 0, 0, 4),
      array('100', '', new \DateTime('2014-12-20 08:25:25'), null, null, 0, 0, 5),
      array('25', 'Commentaire', new \DateTime('2015-02-13 07:54:10'), null, null, 0, 0, 6)
    );

    foreach ($valeur as $ligne) {

      // On crée la société
      $stock = new Stock();
  
      $stock->setQuantite($ligne[0]);
      $stock->setCommentaire($ligne[1]);
      $stock->setDateEntree($ligne[2]);
      $stock->setDateSortie($ligne[3]);
      $stock->setDateChg($ligne[4]);
      $stock->setBitChg($ligne[5]);
      $stock->setBitSup($ligne[6]);
      $stock->setProduit($this->getReference('produit_'.$ligne[7]));
 
      // On la persiste
      $manager->persist($stock);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 11; // l'ordre dans lequel les fichiers sont chargés
  }
}