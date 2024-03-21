<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Library;
use App\Entity\Reader;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'front_main_home')]
    public function index(): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('main/index.html.twig', [
            'reviews' => $user->getReviews(),
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig');
    }
}
