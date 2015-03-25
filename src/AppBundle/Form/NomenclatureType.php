<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NomenclatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit','entity',array('class' => 'AppBundle:Produits','property' => 'codeProduit'))
			->add('nombre','integer')
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
            'data_class' => 'AppBundle\Entity\Nomenclature'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_nomenclature';
    }
}
