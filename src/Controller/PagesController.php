<?php

namespace App\Controller;

use App\Repository\LocalizationRepository;
use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PagesController extends AbstractController
{

    /**
     * @Route("/test", name="test")
     * @Route("/", name="homepage")
     */

    public function home(Request $request, CallApiService $callApiService, LocalizationRepository $loc, HttpClientInterface $client): Response
    {

        $ask = $request->getContent();

        if ($ask) {

            $test = str_replace('+', ' ', $ask);
            $final = str_replace('localisation=', '', $test);

            $found = $loc->findOneBySomeField([$final]);

        } else {

            $found = $loc->findOneBySomeField(["Paris 02"]);

            $response = $client->request(
                'POST',
                $callApiService->getRootUrl(),
                ["body" => ["lat" => $found->getLat(), "lng" => $found->getLng()]]

            );

            $content = $response->getContent();

            $fromJson = json_decode($content);

            dump($fromJson);

        }

        dump($found);

        $place = $loc->findAll();

        // je recupe les coords de twig
        //

        // $localisation = new Localization();

        // $localisation->setName('Villejuif')
        //     ->setLat(48.79192201524733)
        //     ->setLng(2.3634500865551424);

        // $form = $this->createForm(StoreLocalizationType::class, $localisation);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $localisation = $form->getData();

        //     $em->persist($localisation);
        //     $em->flush();

        //     //ici envoyer la requete au serveur en asynchrone ici

        //     return $this->redirectToRoute('homepage');
        // }

        return $this->render('pages/home.html.twig', [
            'select' => $place,
            'found' => $found,
            'data' => $fromJson,
        ]);
    }

    /**
     * @Route("/another", name="another")
     */

    public function meteoStat(CallApiService $callApiService, HttpClientInterface $client): Response
    {

        //delivre url pour la requete

        $response = $client->request(
            'POST',
            'http://localhost:3000/meteo/average/uvi',
            ["body" => ["lat" => 48.8675848, "lng" => 2.3]]

        );

        // $statusCode = $response->getStatusCode();

        dd($response->getContent());

        return $this->render('pages/home.html.twig');

    }

}
