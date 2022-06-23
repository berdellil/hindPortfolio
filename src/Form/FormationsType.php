<?php

namespace App\Form;

use App\Entity\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormationsType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        ->add('titre',TextType::class,['attr' => ['class'=>'form-control']])
        ->add('organisme',TextType::class,['attr' => ['class'=>'form-control']])
        ->add('logo',TextType::class,['attr' => ['class'=>'form-control']])
       ->add('ajouter',SubmitType::class,['attr' => [
       'class' => 'btn btn_success mt-3'
       ]
       ])
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
