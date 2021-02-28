<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AccountDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar',FileType::class,[
                "data_class" => null,
                'required' => false,
                'constraints'=>[
                    new File([
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage'=> 'Please upload a valid JPEG,JPG, PNG file'
                    ])
                ]
            ])
            ->add('email',EmailType::class, ['required' => false,])
            ->add('lastName', TextType::class,['required' => false,])
            ->add('firstName', TextType::class,['required' => false,])
            ->add('phoneNumber', null,[
                'required'=>false
            ])
            ->add('dateOfBirth', BirthdayType::class,[
                'format' => 'yyyy-MM-dd',
                'required' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
