<?php
// src/AppBundle/DataFixtures/ORM/LoadNomenclature.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Nomenclature;

class LoadNomenclature extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array(4, 'RE15208', 4),
      array(2, 'RE15208', 6),
      array(1, 'PE14542', 4),
      array(1, 'PE14542', 5),
      array(1, 'PE14542', 6),
      array(2, 'FD13633', 5),
      array(2, 'FD13633', 6)
    );

    foreach ($valeur as $ligne) {

      // On crée la société
      $nomenclature = new Nomenclature();
  
      $nomenclature->setQuantite($ligne[0]);
      $nomenclature->setCodeProduit($ligne[1]);
      $nomenclature->setProduit($this->getReference('produit_'.$ligne[2]));

      // On la persiste
      $manager->persist($nomenclature);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 10; // l'ordre dans lequel les fichiers sont chargés
  }
}