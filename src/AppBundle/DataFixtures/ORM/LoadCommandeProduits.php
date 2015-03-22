<?php
// src/AppBundle/DataFixtures/ORM/LoadCommandeProduits.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CommandeProduits;

class LoadCommandeProduits extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array();

    foreach ($valeur as $ligne) {

      // On crée la société
      $details = new CommandeProduits();
  
      $details->setQuantite($ligne[0]);
      $details->setCommande($this->getReference('commande_'.$ligne[1]));
      $details->setProduit($this->getReference('produit_'.$ligne[2]));

      // On la persiste
      $manager->persist($details);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 4; // l'ordre dans lequel les fichiers sont chargés
  }
}