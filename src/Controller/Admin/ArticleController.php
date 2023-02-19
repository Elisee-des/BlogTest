<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\Admin\AritcleCreationType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article_liste')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }

    #[Route('/article/ajout', name: 'article_ajout')]
    public function ajoute(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $article = new Article();

        $form = $this->createForm(AritcleCreationType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $article->setDateCreation(new \DateTime());
            $article->setUser($user);

            $em->persist($article);
            $em->flush();

            $this->addFlash(
               'success',
               'Article creer avec succes'
            );

            return $this->redirectToRoute('admin_article_liste');
        }

        return $this->render('admin/article/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/edition', name: 'article_edition')]
    public function edition(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

        $form = $this->createForm(AritcleCreationType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $article->setDateCreation(new \DateTime());

            $em->persist($article);
            $em->flush();

            $this->addFlash(
               'success',
               'Article creer avec succes'
            );

            return $this->redirectToRoute('admin_article_liste');
        }

        return $this->render('admin/article/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/suppression', name: 'article_suppression')]
    public function suppression(): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
