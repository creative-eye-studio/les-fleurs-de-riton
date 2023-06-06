<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lname', TextType::class, [
                'label' => 'Nom',
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('fname', TextType::class, [
                'label' => 'Prénom',
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Adresse E-Mail',
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('tel', TextType::class, [
                'label' => 'Téléphone (Optionnel)',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Objet de votre message',
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'row_attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('rgpd_checkbox', CheckboxType::class, [
                'label' => "En soumettant ce formulaire, j'accepte que mes données soient utilisées à des fins de relation client tout en sachant que je peux faire une demande de modification ou de suppression de mes données. Le formulaire est protégé par Google ReCaptcha",
                'row_attr' => [
                    'class' => 'form-input checkbox'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
