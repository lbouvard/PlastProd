<?php
// src/AppBundle/DataFixtures/ORM/LoadSociete.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Societe;

class LoadSociete extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('PlastProd', '1 rue du comodo', '', '54600', 'Villers-Lès-Nancy', 'France', 'M', 'Société mère', null, 0, 0),
      array('Valeo', 'ZI dormant', '', '69000', 'Lyon', 'France', 'F', '', null, 0, 0),
      array('Ideal', '150 avenue du général Leclerc', '', '75001', 'Paris', 'France', 'F', '', null, 0, 0),
      array('PlasticLux', '12 strassen Gerd', '', 'L-1250', 'Luxembourg', 'Luxembourg', 'F', '', null, 0, 0),
      array('Societe1', 'ZI Fessel', '', '69000', 'Lyon', 'France', 'C', '', null, 0, 0),
      array('Societe2', '16 rue du clos', '', '93600', 'Bondy', 'France', 'C', '', null, 0, 0),
      array('Boite3', '20 avenue du général de Gaulle', '', '78000', 'Versailles', 'France', 'C', '', null, 0, 0)     
    );

    $i = 1;

    foreach ($valeur as $ligne) {

      // On crée la société
      $societe = new Societe();
  
      $societe->setNomSociete($ligne[0]);
      $societe->setAdresse1($ligne[1]);
      $societe->setAdresse2($ligne[2]);
      $societe->setCodePostal($ligne[3]);
      $societe->setVille($ligne[4]);
      $societe->setPays($ligne[5]);
      $societe->setTypeSociete($ligne[6]);
      $societe->setCommentaire($ligne[7]);
      $societe->setDateModif($ligne[8]);
      $societe->setBitModif($ligne[9]);
      $societe->setBitSup($ligne[10]);
  
      // On la persiste
      $manager->persist($societe);

      $this->addReference('societe_'.$i++, $societe);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 0; // l'ordre dans lequel les fichiers sont chargés
  }
}