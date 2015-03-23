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
    $valeur = array(
        array( 1, 'RE15208', 'Comodo208', 'Boite à gant granuleux', 4, 58, 232),
        array( 1, 'PE14542', 'Comodo542', 'Dock prise mobile', 3, 18, 54),
        array( 2, 'FD13633', 'CommandeClim',  'Bloc commande climatisation', 4, 85, 340),
        array( 2, 'PE14542', 'Comodo542', 'Dock prise mobile', 2, 18, 36),
        array( 2, 'RE15208', 'Comodo208', 'Boite à gant granuleux', 15, 58, 870)
    );

    foreach ($valeur as $ligne) {

      // On crée la société
      $details = new CommandeProduits();
  
      $details->setCommande($this->getReference('commande_'.$ligne[0]));
      $details->setCodeProduit($ligne[1]);
      $details->setNomProduit($ligne[2]);
      $details->setDescription($ligne[3]);
      $details->setQuantite($ligne[4]);
      $details->setPrixProduit($ligne[5]);
      $details->setPrixTotal($ligne[6]);

      // On la persiste
      $manager->persist($details);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 10; // l'ordre dans lequel les fichiers sont chargés
  }
}