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
      array('Debut production', 'Début de mise en production'),
      array('Percage', 'Perçages des matières'),
      array('Assemblage', 'Assemblage des matières'),
      array('Controle US', 'Contrôle du produit aux ultra-sons'),
      array('Peinture', 'Habillage du produit'),
      array('Packaging', 'Préparation au stockage'),
      array('Fin production', 'Fin de la production')
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $liste = new ListeEtat();
  
      $liste->setLibelle($ligne[0]);
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
    return 8; // l'ordre dans lequel les fichiers sont chargés
  }
}