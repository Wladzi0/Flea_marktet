<?php

namespace App\Form;

use App\Entity\Advertisement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class,[
                'required'=>true,
                'label'=>'Please upload a file',
                'multiple'=>true,
                'mapped'=>false,


            ])
            ->add('name', TextType::class,[
                'required' => true,
                'label'=>"Title"
            ])
            ->add('description', TextareaType::class,[
                'required' => true,
                'attr'=>['max_length' => 10000],

            ])
            ->add('subcategory')
            ->add('price',MoneyType::class,[
                'required' => true,
                'label'=> 'Price',

            ])

            ->add('contactName', TextType::class,[
                'required' => true,
                'label'=> 'Contact person',

            ])
            ->add('telNumber', TextType::class,[
                'required' => true,
                'label'=> 'Telephone number',

            ])
            ->add('location', TextType::class,[
                'required' => true,
                'label'=> 'Location',

            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
        ]);
    }
}
