<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //Le champ child est en réalité les noms des attributs de mon entité (ici entité User) donc
                //si ça ne correspond à rien = erreur => faut rajouter mapped => false (permet de ne pas chercher dans entité)

            ->add('email', EmailType::class, [
                'disabled'=> true,
                'label'=>'Mon email : ',
                'attr'=> [

                ]
            ])
            ->add('password', PasswordType::class, [
                'required'=> true,
                'label' =>'Mot de passe actuel :',
            ])

            ->add('new_password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'mapped'=> false,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identique',
                'label'=>'Mot de passe',
                'required'=> true,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' =>'Confirmez votre nouveau mot de passe'],
                'attr'=> [
                    'placeholder'=>'Saisissez votre mot de passe'
                ]
            ])

            ->add('firstname', TextType::class, [
                'disabled'=> true,
                'label'=>'Mon prénom : '
            ])
            ->add('lastname', TextType::class, [
                'disabled'=> true,
                'label'=>'Mon nom : '
            ])
            ->add('submit', SubmitType::class, [

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
