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
    $valeur = array();

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $commande = new Commande();
  
      $commande->setMontant($ligne[0]);
      $commande->setDateCommande($ligne[1]);
      $commande->setEtatCommande($ligne[2]);
      $commande->setCommentaire($ligne[3]);
      $commande->setDateChg($ligne[4]);
      $commande->setBitChg($ligne[5]);
      $commande->setBitSup($ligne[6]);
      $commande->setCommercial($this->getReference('contact_'.$ligne[7]));
      $commande->setClient($this->getReference('societe_'.$ligne[8])); 

      // On la persiste
      $manager->persist($commande);

      $this->addReference('commande_'.$i++, $commande);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 5; // l'ordre dans lequel les fichiers sont chargés
  }

}