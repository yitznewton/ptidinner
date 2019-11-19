<?php

namespace DinnerBundle\Form;

use DinnerBundle\Entity\Honoree;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('familyName')
            ->add('title')
            ->add('hisName')
            ->add('herName')
            ->add('streetAddress')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('country')
            ->add('phone')
            ->add('mobile')
            ->add('fax')
            ->add('email')
            ->add('referredBy')
            ->add('pledge2019', NumberType::class, ['label' => 'Current pledge'])
            ->add('paid')
            ->add('paidSeats')
            ->add('compSeats')
            ->add('isBusiness', CheckboxType::class, ['label' => 'Business?', 'required' => false])
            ->add('thisYearOnly')
            ->add('doNotCall')
            ->add('note')
            ->add('previousAdCopy')
            ->add('honorees', EntityType::class, [
                'class' => Honoree::class,
                'label' => 'Honoree affiliation',
                'multiple' => true,
                'required' => false,
            ]);
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
