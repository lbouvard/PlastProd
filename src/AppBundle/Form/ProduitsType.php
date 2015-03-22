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
        $builder
            ->add('nomFournisseur', 'text')
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
            ))
        ;
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
