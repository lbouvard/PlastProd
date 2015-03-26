<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\SocieteRepository;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societe', 'entity', array(
                'class' => 'AppBundle:Societe',
                'property' => 'nomSociete',
                'multiple' => false, 
                'query_builder' => function(SocieteRepository $repo) {
                    return $repo->getListeCompteForm();
                } 
            ))
            ->add('nomContact', 'text')
            ->add('prenomContact', 'text')
            ->add('intitulePoste', 'text')
            ->add('telFixe', 'text', array('required' => false))
            ->add('telMobile', 'text', array('required' => false))
            ->add('fax', 'text', array('required' => false))
            ->add('email', 'text')
            ->add('adresse', 'text')
            ->add('codePostal', 'text')
            ->add('ville', 'text')
            ->add('pays', 'text')
            ->add('commentaire', 'textarea', array('required' => false))
            ->add('valider', 'submit')
            ->add('annuler', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_contact';
    }
}
