<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('note', IntegerType::class, [
            'label' => 'Note', // Ajout d'une étiquette pour le champ "rating"
            'attr' => [
                'min' => 0,
                'max' => 10,
            ],
        ])
        ->add('readingDate', DateType::class, [
            'label' => 'Date de lecture', // Ajout d'une étiquette pour le champ "readingDate"
            'widget' => 'single_text',
        ])
        ->add('opinion', TextareaType::class, [
            'label' => 'Opinion', // Ajout d'une étiquette pour le champ "opinion"
        ])
        ->add('book', EntityType::class, [
            'class' => Book::class,
            'label' => 'Livre', // Ajout d'une étiquette pour le champ "book"
            'choice_label' => 'name',
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
