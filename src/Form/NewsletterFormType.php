<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'row_attr' => [
                    'class' => 'form-input'
                ],
                'attr' => [
                    'placeholder' => "Votre Adresse E-Mail",
                ]
            ])
            ->add('rgpd_checkbox', CheckboxType::class, [
                'label' => "En soumettant ce formulaire, j'accepte que mes données soient utilisées à des fins de marketing tout en sachant que je peux faire une demande de modification ou de suppression de mes données. Le formulaire est protégé par Google ReCaptcha",
                'row_attr' => [
                    'class' => 'form-input checkbox'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'row_attr' => [
                'class' => 'newsletter-form'
            ]
        ]);
    }
}
