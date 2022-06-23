<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Nom']])
            ->add('prenom',TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'], 'label' => 'Prénom'])
            ->add('email',TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Email'], 'label' => 'E-mail'])
            ->add('description',TextareaType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Votre message'], 'label' => 'Message'])
            
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-secondary btn-lg form-control my-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
