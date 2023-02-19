<?php

namespace App\Controller\Main;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main', name: 'main_')]
class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('main/article/index.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }
}
