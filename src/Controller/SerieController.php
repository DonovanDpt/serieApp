<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/series', name: 'serie')]
class SerieController extends AbstractController
{
    #[Route('/', name: '_series')]
    public function series(
        SerieRepository $serieRepository //injection de dépendance
    ): Response
    {
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
}
