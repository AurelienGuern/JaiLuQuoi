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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajouter un champ pour la couverture du livre
           
            ->add('note', RangeType::class, [
                'label' => 'Note',
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1, // pas de 1
                    'class' => 'form-range', // classe Bootstrap pour un champ de type range
                ],
                'label_attr' => [
                    'class' => 'mb-2', // Ajoute une marge en bas du libellé
                ],
            ])
            
            ->add('readingDate', DateType::class, [
                'label' => 'Date de lecture',
                'widget' => 'single_text',
                'attr' => [
                'class' => 'form-control', // classe Bootstrap pour un champ de type range
            ],
            'label_attr' => [
                'class' => 'mb-2', // Ajoute une marge en bas du libellé
            ],
            ])
            ->add('opinion', TextareaType::class, [
                'label' => 'Opinion',
                'attr' => [
                    'class' => 'form-control', // classe Bootstrap pour un champ de type range
                    'rows' => 5
                ],
                'label_attr' => [
                    'class' => 'mb-2', // Ajoute une marge en bas du libellé
                ],
            ])
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'label' => 'Livre',
                'attr' => [
                    'class' => 'form-control', // classe Bootstrap pour un champ de type range
                ],
                'label_attr' => [
                    'class' => 'mb-2', // Ajoute une marge en bas du libellé
                ],
                'choice_label' => function (Book $book) {
                    return $book->getName() . ' - ' . $book->getAuthor()->getFirstname() . ' ' . $book->getAuthor()->getLastname(); // Concaténation du nom du livre avec le nom complet de l'auteur
                },
               ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
