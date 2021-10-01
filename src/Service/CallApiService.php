<?php

namespace App\Service;

use App\Repository\TransactionRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    // Fonction permettant de faire appel à l'API et de retourner son contenu

    public function callAPI()
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        // Pour limiter la consommation de crédit de l'API et améliorer la vitesse de réponse,
        // on limite les retours aux 10 premières crypto-monnaies,
        // ce qui comprend les 3 crypto-monnaies qui nous intéresse
        $parameters = [
            'start' => '1',
            'limit' => '6',
            'convert' => 'EUR'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 5fb83aed-4385-4684-9bf3-704b51fc881d'
        ];
        $qs = http_build_query($parameters);// query string encode the parameters
        $request = "{$url}?{$qs}";// create the request URL

        $curl = curl_init();// Set cURL options

        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,               // set the request URL
            CURLOPT_HTTPHEADER => $headers,        // set the headers
            CURLOPT_RETURNTRANSFER => 1            // ask for raw response instead of bool
        ));

        $response = curl_exec($curl);    // Send the request, save the response

        $resultat = json_decode($response, true); // print json decoded response

        curl_close($curl);                           // Close request

        return $resultat;

    }
    // on retourne le taux du bitcoin
        public function CurrentPriceBitcoin(CallApiService $callApiService)
    {
        $dataApi = $callApiService->callAPI();

        return $CurrentPriceBitcoin = 38756;//$dataApi['data'][0]['quote']['EUR']['price'];
    }
    
     // on retourne le taux de l'Ethereum
        public function CurrentPriceEthereum(CallApiService $callApiService)
    {
        $dataApi = $callApiService->callAPI();

        return $CurrentPriceEthereum = $dataApi['data'][1]['quote']['EUR']['price'];
    }

      // on retourne le taux du Ripple
        public function CurrentPriceRipple(CallApiService $callApiService)
    {
        $dataApi = $callApiService->callAPI();

        return $CurrentPriceRipple = $dataApi['data'][5]['quote']['EUR']['price'];
    }
}



