<?php
// src/AppBundle/DataFixtures/ORM/LoadContact.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Contact;

class LoadContact extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('Antoine','Auguste', 'Commercial', '+33421689514', '+33634659871', null, 'antoine.auguste@valeo.com', 'ZI dormant', '69000', 'Lyon', 'France', '', null, 0, 0, 2, 1),
      array('Bouvard','Laurent', 'Tech IT', '+33383256594', '+33645986147', null, 'laurent.bouvard@plastprod.fr', '1 rue du comodo', '54600', 'Villers-Lès-Nancy', 'France', '', null, 0, 0, 1, 2),
      array('Convenant','Claude', 'Commercial', '+33145328564', '+33610447251', null, 'convenant.claude@boite3.fr', '20 avenue du général de Gaulle', '78000', 'Versailles', 'France', '', null, 0, 0, 7, 3),
      array('Dupond','Jean', 'Commercial', '+33383256598', '+33612356898', null, 'jean.dupond@plastprod.fr', '1 rue du comodo', '54600', 'Villers-Lès-Nancy', 'France', 'Commentaire', null, 0, 0, 1, 4),
      array('Kruger','Gerald', 'Commercial', '+352275465', '', null, 'kruger.gerald@plasticlux.lu', '12 strassen Gerd', 'L-1250', 'Luxembourg', 'Luxembourg', '', null, 0, 0, 4, 5), 
      array('Lemoine','Alain', 'Commercial', '+33133443002', '+33610447251', null, 'alain.lemoine@societe2.fr', '16 rue du clos', '93600', 'Bondy', 'France', '', null, 0, 0, 6, 6),
      array('Morandi','Pierre', 'Directeur technique', '+33445238590', '+33645464724', null, 'pierre.morandi@societe1.fr', 'ZI Fessel', '69000', 'Lyon', 'France', '', null, 0, 0, 5, 7),
      array('Muller','Yvan', 'Commercial', '+33160468521', '+33633456598', null, 'muller.yvan@ideal.fr', '150 avenue du général Leclerc', '75001', 'Paris', 'France', '', null, 0, 0, 3, 8)
    );

    $i = 1;
    
    foreach ($valeur as $ligne) {

      // On crée la société
      $contact = new Contact();
  
      $contact->setNomContact($ligne[0]);
      $contact->setPrenomContact($ligne[1]);
      $contact->setIntitulePoste($ligne[2]);
      $contact->setTelFixe($ligne[3]);
      $contact->setTelMobile($ligne[4]);
      $contact->setFax($ligne[5]);
      $contact->setEmail($ligne[6]);
      $contact->setAdresse($ligne[7]);
      $contact->setCodePostal($ligne[8]);
      $contact->setVille($ligne[9]);
      $contact->setPays($ligne[10]);
      $contact->setCommentaire($ligne[11]);
      $contact->setDateModif($ligne[12]);
      $contact->setBitModif($ligne[13]);
      $contact->setBitSup($ligne[14]);
      $contact->setSociete($this->getReference('societe_'.$ligne[15]));
      $contact->setUtilisateur($this->getReference('utilisateur_'.$ligne[16]));

      // On la persiste
      $manager->persist($contact);

    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 3; // l'ordre dans lequel les fichiers sont chargés
  }
}