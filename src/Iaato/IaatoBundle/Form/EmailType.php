<?php

namespace Iaato\IaatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Iaato\IaatoBundle\Entity\Email;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', 'email')
            ->add('email', 'email')
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Iaato\IaatoBundle\Entity\Email'
        ));
    }

    public function getName()
    {
        return 'iaato_iaatobundle_emailtype';
    }
}
