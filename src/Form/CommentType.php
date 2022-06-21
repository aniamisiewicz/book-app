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

use App\Entity\Comment;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * CommentType class.
 */
class CommentType extends AbstractType
{
    /**
     * Constructor.
     *
     * @param Security $security Security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder Builder
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (null === $this->security->getUser()) {
            $builder
            ->add('email', TextType::class, [
                'attr' => ['class' => 'input'],
                'required' => true,
            ])
            ->add('nick', TextType::class, [
                'attr' => ['class' => 'input'],
                'required' => true,
            ]);
        }
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'input'],
                'required' => true,
            ]);
    }

    /**
     * Configures options.
     *
     * @param OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
