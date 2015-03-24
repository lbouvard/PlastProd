<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\ProduitsRepository;
use AppBundle\Entity\SocieteRepository;

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
                ));
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
                    ->add('codeProduit', 'text')
                    ->add('nomProduit', 'text')
                    ->add('descriptionProduit', 'textarea')
                    ->add('categorieProduit', 'text')
                    ->add('prixProduit', 'text')
                    ->add('quantite', 'integer')
                    ->add('valider', 'submit')
                    ->add('annuler', 'submit');
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produits', 'produit_fournisseur' => true
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
