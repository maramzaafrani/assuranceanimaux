<?php

namespace App\Form;

use App\Entity\BilanDeSoin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BilanDeSoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('IdClient')
            ->add('IdVeterinaire')
            ->add('Animal')
            ->add('Description')
            ->add('Prix')
            ->add('etat', ChoiceType::class,[ 'choices' =>['non étudié'=>'non étudié','accepté'=>'accepté' , 'refusé'=>'refusé']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BilanDeSoin::class,
        ]);
    }
}
