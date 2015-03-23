<?php
// src/AppBundle/DataFixtures/ORM/LoadCommande.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Commande;

class LoadCommande extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
          array( new \DateTime('2015-03-17 18:59:05'), 'Commentaire', 1, 5),
          array( new \DateTime('2015-03-17 19:38:52'), null, 3, 7)
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $commande = new Commande();
  
      $commande->setDateCommande($ligne[0]);
      $commande->setCommentaire($ligne[1]);
      $commande->setCommercial($this->getReference('contact_'.$ligne[2]));
      $commande->setClient($this->getReference('societe_'.$ligne[3])); 

      // On la persiste
      $manager->persist($commande);

      $this->addReference('commande_'.$i++, $commande);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 8; // l'ordre dans lequel les fichiers sont chargés
  }

}