<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

/**
 * UserType class.
 */
class UserType extends AbstractType
{
    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder Builder
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, [
            'attr' => ['class' => 'input'],
            'required' => false,
        ])
        ->add(
            'plainPassword',
            RepeatedType::class,
            [
                'label' => 'label.password',
                'required' => true,
                'type' => PasswordType::class,
                'first_options' => ['label' => 'password'],
                'second_options' => ['label' => 'password'],
            ]
        )
        ->add('name', TextType::class, [
            'attr' => ['class' => 'input'],
            'required' => false,
        ])
        ->add('roles', ChoiceType::class, [
            'required' => true,
            'multiple' => false,
            'expanded' => false,
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
            ],
            'attr' => ['class' => 'input'],
        ]);

        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                // transform the array to a string
                return count($rolesArray) ? $rolesArray[0] : null;
            },
            function ($rolesString) {
                // transform the string back to an array
                return [$rolesString];
            }
        ));
    }

    /**
     * Configures options.
     *
     * @param OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
