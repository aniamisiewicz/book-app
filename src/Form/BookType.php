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

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * BookType form class.
 */
class BookType extends AbstractType
{
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository Category repository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder Builder
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = [];
        $categories = $this->categoryRepository->findAll();
        foreach ($categories as $c) {
            array_push($data, $c);
        }

        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'input'],
                'required' => false,
            ])
            ->add('author', TextType::class, [
                'attr' => ['class' => 'input'],
                'required' => false,
            ])
            ->add('category', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'input'],
                'choices' => $data,
                'choice_label' => function ($choice) {
                    return $choice->getName();
                },
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
            'data_class' => Book::class,
        ]);
    }
}
