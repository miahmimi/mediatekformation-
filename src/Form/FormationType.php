<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class,[
                'widget'=>'single_text',
                'label'=>'Date / Heure de publication',
                'required'=>true 
                
                ])
            ->add('title',null,[
                'label'=>'Titre',
                'required'=>true 
            ])
            ->add('Description')
            ->add('videoId', null,[
                'required'=>false 
            ])
            ->add('playlist',null,[
                'required'=>true 
            ])
            ->add('categories')
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
