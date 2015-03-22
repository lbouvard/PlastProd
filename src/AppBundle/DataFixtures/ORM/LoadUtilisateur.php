<?php
// src/AppBundle/DataFixtures/ORM/LoadUtilisateur.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use AppBundle\Entity\Utilisateur;

class LoadUtilisateur extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {

    $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);

    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Antoine Auguste', '1234', 'antoine.auguste@valeo.com', null, 0, 0),
      array('Bouvard Laurent', 'admin1234', 'laurent.bouvard@plastprod.fr', null, 0, 0),
      array('Convenant Claude', '1234', 'convenant.claude@boite3.fr', null, 0, 0),
      array('Dupond Jean', 'com1234', 'jean.dupond@plasprod.fr', null, 0, 0),
      array('Kruger Gerald', '1234', 'kruger.gerald@plasticlux.lu', null, 0, 0),
      array('Lemoine Alain', '1234', 'alain.lemoine@ideal.fr', null, 0, 0),
      array('Morandi Pierre', '1234', 'pierre.morandi@ideal.fr', null, 0, 0),
      array('Muller Yvan', '1234', 'muller.yvan@border.fr', null, 0, 0)
    );

    $i = 1;

    foreach ($valeur as $ligne) {

      // On crée la société
      $user = new Utilisateur();
  
      $user->setUserName($ligne[0]);
      $user->setPassword( $encoder->encodePassword($ligne[1], $user->getSalt()) );
      $user->setEmail($ligne[2]);
      $user->setDateModif($ligne[3]);
      $user->setBitModif($ligne[4]);
      $user->setBitSup($ligne[5]);
  
      // On la persiste
      $manager->persist($user);

      $this->addReference('utilisateur_'.$i++, $user);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 2; // l'ordre dans lequel les fichiers sont chargés
  }

}