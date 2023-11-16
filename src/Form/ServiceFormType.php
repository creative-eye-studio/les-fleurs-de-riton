<?php

namespace App\Form;

use App\Entity\Services;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => "Nom du service"
            ])
            ->add('pos', NumberType::class, [
                'label' => "Positionnement",
                'html5' => true
            ])
            ->add('title', TextType::class, [
                'label' => "Titre du service"
            ])
            ->add('content', CKEditorType::class, [
                'label' => "Contenu du service"
            ])
            ->add('images', DropzoneType::class, [
                'label' => "Images du service",
                'mapped' => false,
                'multiple' => true,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
