<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\ProduitsRepository;

class ProduitsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if( $options['produit_fournisseur'] )
        {
            $builder
                ->add('nomProduit', 'text')
                ->add('descriptionProduit', 'textarea')
                ->add('categorieProduit', 'text')
                ->add('codeProduit', 'text')
                ->add('prixProduit', 'money')
                ->add('producteur', 'entity', array(
                    'class' => 'AppBundle:Societe',
                    'property' => 'nomSociete',
                    'multiple' => false, 
                    'query_builder' => function(SocieteRepository $repo) {
                        return $repo->getListeFournisseur();
                    } 
                )
            );
        }
        else
        {
            //ajout d'un produit
            $builder
                    ->add('producteur', 'entity', array(
                        'class'=>'AppBundle:Societe',
                        'property' => 'nomSociete', 
                        'multiple' => false, 
                        'query_builder' => function(SocieteRepository $repo) {
                            return $repo->getListeFournisseurStock();
                            }
                    ))
                    ->add('codeProduit', 'text', array("label"=>"Code Produit"))
                    ->add('nomProduit', 'text', array("label"=>"Nom"))
                    ->add('descriptionProduit', 'text', array("label"=>"Description"))
                    ->add('categorieProduit', 'text', array("label"=>"Catégorie"))
                    ->add('prixProduit', 'text', array("label"=>"Prix"))
                    ->add('quantite', 'integer');
                    ->add('droit', 'submit');
                    ->add('annuler', 'submit') ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produits'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_produits';
    }
}
