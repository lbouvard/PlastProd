<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SocieteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSociete', 'text')
            ->add('adresse1', 'text')
            ->add('adresse2', 'text', array('required' => false))
            ->add('codePostal', 'text')
            ->add('ville', 'text')
            ->add('pays', 'text')
            ->add('commentaire', 'textarea', array('required' => false))
            ->add('Valider', 'submit')
            ->add('Annuler', 'reset')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Societe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_societe';
    }
}
