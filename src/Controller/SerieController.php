<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/series', name: 'serie')]
class SerieController extends AbstractController
{
    #[Route('/', name: '_series')]
    public function series(
        SerieRepository $serieRepository //injection de dépendance
    ): Response
    {
        $utilisateurConnecte = $this->getUser();
        dump($utilisateurConnecte);
        $tabDeSeries = $serieRepository->findAll();
        return $this->render(
            'serie/series.html.twig',
            compact('tabDeSeries')

        );
    }

    #[Route('/{serie}',
        name: '_serie',
        requirements: ["serie" => '\d+']
    )]
    public function serie(
        Serie $serie,
//        SerieRepository $serieRepository
    ): Response
    {   //Pour en récupérer plusieurs
//        $serieRepository->findBy();
        //Pour en récuperer qu'un seul
//        $serie = $serieRepository->findOneBy(
//            ["id" => $id], //WHERE
//            ["nom" => "DESC"], //ORDER BY
//        );

        return $this->render('serie/serie.html.twig',
        compact(var_name: 'serie')
        );
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ajouter', name: '_ajouter')]
    public function ajouter(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $serie = new Serie();
        $serie->setNom("Game of Throne");
        $serieForm = $this->createForm(SerieType::class, $serie);
        //permet de récuperer les informations du formulaire
        $serieForm->handleRequest($request);
        //Si l'utilisateur a envoyer le form, on le redirige vers la page où il ajoute son élément
        if ($serieForm->isSubmitted() && $serieForm->isValid()){
            //methode qui permet d'update en base de donnée
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->redirectToRoute('serie_series');
        }

        return $this->render(
            'serie/ajouter.html.twig',
            compact('serieForm')
        );
    }
}
