<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\SocieteRepository;
use AppBundle\Entity\ContactRepository;

class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', 'entity', array(
                'class' => 'AppBundle:Societe',
                'property' => 'nomSociete',
                'multiple' => false, 
                'query_builder' => function(SocieteRepository $repo) {
                    return $repo->getListeClient();
                } 
            ))
            ->add('commercial', 'entity', array(
                'class' => 'AppBundle:Contact',
                'property' => 'nomContact',
                'multiple' => false, 
                'query_builder' => function(ContactRepository $repo) {
                    return $repo->getCommerciaux();
                }
            ))
            ->add('commentaire', 'textarea', array('required' => false))
            ->add('produits', 'collection', array(
                'type'         => new CommandeProduitsType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('valider', 'submit')
            ->add('annuler', 'reset')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commande'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_commande';
    }
}
