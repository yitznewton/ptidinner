<?php

namespace DinnerBundle\Form;

use DinnerBundle\Entity\Guest;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adType')
            ->add('copy')
            ->add('note')
            ->add('sentToPrinter', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('proofFromPrinter')
            ->add('proofApproved')
            ->add('guests', EntityType::class, [
                'class' => Guest::class,
                'label' => 'This ad is for',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')->orderBy('g.familyName, g.hisName', 'ASC');
                },
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DinnerBundle\Entity\Ad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dinnerbundle_ad';
    }


}
