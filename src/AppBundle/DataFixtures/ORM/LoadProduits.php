<?php
// src/AppBundle/DataFixtures/ORM/LoadProduits.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Produits;

class LoadProduits extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $valeur = array(
      array('PlastProd', 'Comodo208', 'Boite à gant granuleux', 'Automobile', 'RE15208', 58, null, 0, 0, 1),
      array('PlastProd', 'Comodo542', 'Dock prise mobile', 'Automobile', 'PE14542', 18, null, 0, 0, 1),
      array('PlastProd', 'CommandeClim', 'Bloc commande climatisation', 'Automobile', 'FD13633', 85, null, 0, 0, 1),
      array('Valeo', 'Plast1254', 'Attache universel', 'General', '125475621', 10, null, 0, 0, 2),
      array('Valeo', 'Bouton diam25', 'Bouton poussoir soft', 'Connectique', 'B5412S-25', 3, null, 0, 0, 2),
      array('PlasticLux', 'Bande PVC', 'Bande PVC noir mat', 'Matiere', '546454SS', 15, null, 0, 0, 5)
    );

    $i = 1;

    foreach ($valeur as $ligne) {

      // On crée la société
      $produit = new Produits();
  
      $produit->setNomFournisseur($ligne[0]);
      $produit->setNomProduit($ligne[1]);
      $produit->setDescriptionProduit($ligne[2]);
      $produit->setCategorieProduit($ligne[3]);
      $produit->setCodeProduit($ligne[4]);
      $produit->setPrixProduit($ligne[5]);
      $produit->setDateModif($ligne[6]);
      $produit->setBitModif($ligne[7]);
      $produit->setBitSup($ligne[8]);
      $produit->setProducteur($this->getReference('societe_'.$ligne[9]));
  
      // On la persiste
      $manager->persist($produit);

      $this->addReference('produit_'.$i++, $produit);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }

  public function getOrder()
  {
    return 9; // l'ordre dans lequel les fichiers sont chargés
  }
}