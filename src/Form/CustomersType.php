<?php

namespace App\Form;

use App\Entity\Customers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter your username',
                    'required oninvalid' => 'this.setCustomValidity("Please enter username here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]
     
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Not match',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password', 'attr' => [
                    'placeholder' => 'Enter your password',
                    'required oninvalid' => 'this.setCustomValidity("Please enter the password here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]],
                'second_options' => ['label' => 'Confirm password', 'attr' => [
                    'placeholder' => 'Confirm your password',
                    'required oninvalid' => 'this.setCustomValidity("Please confirm the password here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]]
            ])
            ->add('Fullname', TextType::class, ['label' => 'Full name',
                 'attr' => [
                    'placeholder' => 'Enter your full name',
                    'required oninvalid' => 'this.setCustomValidity("Please enter the full name here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]
            ])
            ->add('Email', EmailType::class, [
                 'attr' => [
                    'placeholder' => 'Enter your email',
                    'required oninvalid' => 'this.setCustomValidity("Please enter the email here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]
            ])
            ->add('Address', TextType::class, [
                 'attr' => [
                    'placeholder' => 'Enter your address',
                    'required oninvalid' => 'this.setCustomValidity("Please enter the address here!")',
                     'oninput' => 'setCustomValidity("")'
                    ]
            ])
            ->add('Phone', TextType::class, [
                 'attr' => [
                    'placeholder' => 'Enter your phone number',
                    'required oninvalid' => 'this.setCustomValidity("Please enter the phone number here!")',
                    'oninput' => 'setCustomValidity("")', 'onkeydown'=>"javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"
                    ]
            ])
            ->add('Gender', ChoiceType::class, [
                'choices' => [
                    'Gender' => [
                    'Male' => 'Male',
                    'Female' => 'Female'
                 ]],
            ])
            ->add('Birthday', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('humanCheck', CheckboxType::class, ['mapped' => false, 'label' => 'You are not a robot',
                'attr' => [
                    'oninvalid' => 'this.setCustomValidity("Please check this box if you want to proceed")',
                    'onclick' => 'setCustomValidity("")'
                    ]
            ])
            ->add('Register', SubmitType::class, [
                'attr' => [
            
                    'class' => 'btn',
                    'style' => 'margin-left: -5px'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
            // Configure your form options here
        ]);
    }
}