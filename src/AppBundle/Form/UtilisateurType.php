<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('isActive', 'checkbox', array('required' => false))
            ->add('mdpTemp', 'password', array('required' => false))
            ->add('modifier', 'submit');

            if( $options['utilise_droit'] )
                $builder->add('droit', 'submit');

            $builder->add('annuler', 'submit') ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur', 'utilise_droit' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_utilisateur';
    }
}
