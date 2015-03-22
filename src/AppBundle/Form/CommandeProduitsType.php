<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\ProduitsRepository;

class CommandeProduitsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeproduit', 'text', array('label' => false, 'read_only' => true))
            ->add('nomproduit', 'text', array('label' => false, 'read_only' => true))
            ->add('description', 'text', array('label' => false, 'read_only' => true)) 
            ->add('prixproduit', 'money', array('label' => false, 'read_only' => true))
            ->add('quantite', 'integer', array('label' => false))
            ->add('prixtotal', 'money', array('label' => false, 'read_only' => true)) 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CommandeProduits'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_commandeproduits';
    }
}
