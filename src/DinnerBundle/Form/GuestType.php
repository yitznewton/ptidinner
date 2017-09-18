<?php

namespace DinnerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ykpId')->add('familyName')->add('title')->add('herName')->add('hisName')->add('note')->add('pledge2013')->add('pledge2014')->add('pledge2015')->add('paid')->add('streetAddress')->add('city')->add('state')->add('zip')->add('country')->add('phone')->add('mobile')->add('fax')->add('email')->add('referredBy')->add('paidSeats')->add('compSeats')->add('previousAdCopy')->add('previousAdTypes')->add('isBusiness')->add('doNotCall')->add('ads')->add('honorees');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DinnerBundle\Entity\Guest'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dinnerbundle_guest';
    }


}
