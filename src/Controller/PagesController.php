<?php

namespace App\Controller;

use App\Repository\LocalizationRepository;
use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PagesController extends AbstractController
{

    /**
     * @Route("/rainyday", name="rainyday")
     * @Route("/average/uvi", name="avgUvi")
     * @Route("/mosthotdays", name="threeDays")
     * @Route("/average/temp", name="averageTemperatures")
     * @Route("/", name="homepage")
     */

    public function home(Request $request, CallApiService $callApiService, LocalizationRepository $loc, HttpClientInterface $client, SessionInterface $session): Response
    {

        $ask = $request->getContent();

        if ($ask) {

            $str = str_replace('+', ' ', $ask);
            $final = str_replace('localisation=', '', $str);

            $found = $loc->findOneBySomeField([$final]);

            if ($found) {
                $session->set('name', $found->getName());
                $session->set('lat', $found->getLat());
                $session->set('lng', $found->getLng());
            }

        } else {

            $found = $loc->findOneBySomeField(["Paris 02"]);
            $session->set('lat', $found->getLat());
            $session->set('lng', $found->getLng());

        }

        $routeName = $request->attributes->get('_route');

        switch ($routeName) {
            case 'averageTemperatures':

                $response = $client->request(
                    'POST',
                    $callApiService->getUrlAvgTemp(),
                    ["body" => ["lat" => $session->get('lat'), "lng" => $session->get('lng')]]

                );

                $content = $response->getContent();

                $stat = json_decode($content);

                $session->set('stat', $stat);

                break;

            case 'threeDays':

                $response = $client->request(
                    'POST',
                    $callApiService->getUrlMostHotDays(),
                    ["body" => ["lat" => $session->get('lat'), "lng" => $session->get('lng')]]

                );

                $content = $response->getContent();

                $stat = json_decode($content);

                $session->set('stat', $stat);

                break;

            case 'avgUvi':

                $response = $client->request(
                    'POST',
                    $callApiService->getUrlAvgUvi(),
                    ["body" => ["lat" => $session->get('lat'), "lng" => $session->get('lng')]]

                );

                $content = $response->getContent();

                $stat = json_decode($content);

                $session->set('stat', $stat);

                break;

            case 'rainyday':

                $response = $client->request(
                    'POST',
                    $callApiService->getUrlRainfallDay(),
                    ["body" => ["lat" => $session->get('lat'), "lng" => $session->get('lng')]]

                );

                $content = $response->getContent();

                $stat = json_decode($content);

                $session->set('stat', $stat);

                break;

            default:

                break;

        }
        $response = $client->request(
            'POST',
            $callApiService->getRootUrl(),
            ["body" => ["lat" => $session->get('lat'), "lng" => $session->get('lng')]]

        );

        $content = $response->getContent();
        $fromJson = json_decode($content);

        $place = $loc->findAll();

        return $this->render('pages/home.html.twig', [
            'select' => $place,
            'found' => $session->get('name'),
            'data' => $fromJson,
            'stat' => $session->get('stat'),
        ]);
    }

    // /**
    //  * @Route("/test", name="test")
    //  */

    //  public function test(MessageBusInterface $bus)
    //  {

    //     return $this -> render('/pages/test.html.twig');

    //  }

}
