<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/wishlist', name: 'app_book_wishlist', methods: ['GET'])]
    public function getWishlist(BookRepository $bookRepository): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $wishList = $user->getWishList();


        return $this->render('book/wishlist.html.twig', [
            'wishlist' => $wishList
        ]);
    }

    #[Route('/wishlist/{id}', name: 'app_book_addWishlist', methods: ['POST'])]
    public function addWishList(Book $book, EntityManagerInterface $entityManager): Response
    {
        // Vérifiez si le livre existe
        if (!$book) {
            throw $this->createNotFoundException('Le livre spécifié n\'existe pas.');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Ajoutez le livre à la liste d'envies de l'utilisateur
        $user->addWishList($book);
        $book->addUser($user);

        // Persistez les modifications dans la base de données
        $entityManager->flush();

        // Redirigez l'utilisateur vers la liste d'envies mise à jour
        return $this->redirectToRoute('app_book_wishlist');
    }

    #[Route('/wishlist/{id}', name: 'app_book_removeWishlist', methods: ['POST'])]
    public function removeWishList(Book $book, EntityManagerInterface $entityManager): Response
    {
        // Vérifiez si le livre existe
        if (!$book) {
            throw $this->createNotFoundException('Le livre spécifié n\'existe pas.');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Vérifiez si le livre est dans la liste d'envies de l'utilisateur
        if (!$user->getWishList()->contains($book)) {
            throw $this->createAccessDeniedException('Le livre spécifié n\'est pas dans votre liste.');
        }

        // Retirez le livre de la liste d'envies de l'utilisateur
        $user->removeWishList($book);
        $book->removeUser($user);

        // Persistez les modifications dans la base de données
        $entityManager->persist($book);
        // Redirigez l'utilisateur vers la liste d'envies mise à jour
        return $this->redirectToRoute('app_book_wishlist');
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $reviews = $book->getReviews();

        foreach ($reviews as $rev) {
            if ($rev->getUser() == $user) {
                $review = $rev;
                break;
            }
        }

        $author = $book->getAuthor();

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'author' => $author,
            'user' => $user,
            'review' => $review
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }


    // #[Route('/random/{id}', name: 'app_book_random', methods: ['GET'])]
    // public function showRandom(BookRepository $bookRepository): Response
    // {
    //     $books = $bookRepository->findAll();
    //     $randomBook = $books[array_rand($books)];
    //     dd($randomBook);

    //     return $this->redirectToRoute('app_book_show', ['id' => $randomBook->getId()]);
    // }

}
