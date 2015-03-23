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
      array('antoine.auguste', '1234', 'antoine.auguste@valeo.com'),
      array('bouvard.laurent', '6!E#zx3V', 'laurent.bouvard@plastprod.fr', '4991665200d3f7111b880dcd62d821d4'),
      array('convenant.claude', '1234', 'convenant.claude@boite3.fr'),
      array('dupond.jean', 'com1234', 'jean.dupond@plasprod.fr'),
      array('kruger.gerald', '1234', 'kruger.gerald@plasticlux.lu'),
      array('lemoine.alain', '1234', 'alain.lemoine@ideal.fr'),
      array('morandi.pierre', '1234', 'pierre.morandi@ideal.fr'),
      array('muller.yvan', '1234', 'muller.yvan@border.fr')
    );

    $i = 1;

    foreach ($valeur as $ligne) {

      // On crée la société
      $user = new Utilisateur();
  
      $user->setUserName($ligne[0]);
      if( isset($ligne[3]) )
      {
        $user->setPassword( $encoder->encodePassword($ligne[1], $ligne[3]) );
        //role admin
        $user->addRole($this->getReference('role_9') );
      }
      else
      {
        $user->setPassword( $encoder->encodePassword($ligne[1], $user->getSalt()) );
        //role client
        $user->addRole($this->getReference('role_13') );
      }

      $user->setEmail($ligne[2]);

      // On la persiste
      $manager->persist($user);

      $this->addReference('utilisateur_'.$i++, $user);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 6; // l'ordre dans lequel les fichiers sont chargés
  }

}