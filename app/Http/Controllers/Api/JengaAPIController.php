<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JengaAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JengaAPIController extends Controller
{

    public function index()
    {
        return accountBalance('KE', '123456789');
    }
    /**
     * Get Bearer Token.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBearerToken()
    {
        $jengaAccount = JengaAccount::first();
        $url = config('jenga.auth_url') . '/authenticate/merchant';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Api-Key' => $jengaAccount->api_key,
        ];
        $body = [
            'merchantCode' => $jengaAccount->merchant_code,
            'consumerSecret' => $jengaAccount->consumer_secret,
        ];
        $response = Http::withHeaders($headers)->post($url, $body);

        if ($response->successful()) {
            $response = json_decode($response->getBody()->getContents());
            return $response->accessToken;
        }

        return response()->json(['error' => 'true', 'message' => json_decode($response->getBody()->getContents())]);
    }

    /**
     * Check Account Balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function payloads()
    {
        $dataBank = [
            "source" =>
            [
                "countryCode" => "KE",
                "name" => "A N.Other",
                "accountNumber" => "0011547896523"
            ],
            "destination" =>
            [
                "type" => "bank",
                "countryCode" => "KE",
                "name" => "John Doe",
                "accountNumber" => "0022547896523"
            ],
            "transfer" =>
            [
                "type" => "InternalFundsTransfer",
                "amount" => "1000.00",
                "currencyCode" => "KES",
                "reference" => "692194625798",
                "date" => "2018-08-18",
                "description" => "some remarks here"
            ]
        ];

        $dataMobile = [
            "source" =>
            [
                "countryCode" => "KE",
                "name" => "John Doe",
                "accountNumber" => "0011547896523"
            ],
            "destination" =>
            [
                "type" => "mobile",
                "countryCode" => "KE",
                "name" => "A N.Other",
                "mobileNumber" => "0763123456",
                "walletName" => "Mpesa"
            ],
            "transfer" =>
            [
                "type" => "MobileWallet",
                "amount" => "1000",
                "currencyCode" => "KES",
                "date" => "2018-08-18",
                "description" => "some remarks here"
            ]
        ];

        $dataRTGS = [
            'source' => [
                'countryCode' => 'KES',
                'name' => 'John Doe',
                'accountNumber' => '0011547896523',
            ],
            'destination' => [
                'type' => 'bank',
                'countryCode' => 'KE',
                'name' => 'A N.Other',
                'bankCode' => '01',
                'accountNumber' => '2564785123',
            ],
            'transfer' => [
                'type' => 'RTGS',
                'amount' => '1000.00',
                'currencyCode' => 'KES',
                'reference' => '692194625798',
                'date' => '2018-08-16',
                'description' => 'some remarks here',
            ],
        ];

        $dataSwift = [
            'source' => [
                'countryCode' => 'KE',
                'name' => 'John Doe',
                'accountNumber' => '0011547896523',
            ],
            'destination' => [
                'type' => 'bank',
                'countryCode' => 'KE',
                'name' => 'A N.Other',
                'bankBic' => 'BOTKJPJTXXX',
                'accountNumber' => '12365489',
                'addressline1' => 'Post Box 56',
            ],
            'transfer' => [
                'type' => 'SWIFT',
                'amount' => '10000.00',
                'currencyCode' => 'USD',
                'reference' => '692194625798',
                'date' => '2018-08-16',
                'description' => 'some description here',
                'chargeOption' => 'SELF',
            ],
        ];

        $pesalinkBank = [
            'source' => [
                'countryCode' => 'KE',
                'name' => 'John Doe',
                'accountNumber' => '0011547896523',
            ],
            'destination' => [
                'type' => 'bank',
                'countryCode' => 'KE',
                'name' => 'A N.Other',
                'mobileNumber' => '0722000000',
                'bankCode' => '01',
                'accountNumber' => '8323524545',
            ],
            'transfer' => [
                'type' => 'PesaLink',
                'amount' => '2000',
                'currencyCode' => 'KE',
                'reference' => '692194625798',
                'date' => '2018-08-18',
                'description' => 'some description',
            ],
        ];

        $pesalinkMobile = [
            'source' => [
                'countryCode' => 'KE',
                'name' => 'John Doe',
                'accountNumber' => '0011547896523',
            ],
            'destination' => [
                'type' => 'mobile',
                'countryCode' => 'KE',
                'name' => 'A N.Other',
                'bankCode' => '01',
                'mobileNumber' => '0722000000',
            ],
            'transfer' => [
                'type' => 'PesaLink',
                'amount' => '1000',
                'currencyCode' => 'KES',
                'reference' => '692194625798',
                'date' => '2018-08-19',
            ],
        ];

        //pesalinkTransferToMobile($pesalinkMobile['source'], $pesalinkMobile['destination'], $pesalinkMobile['transfer']);

        //pesalinkTransferToBank($pesalinkBank['source'], $pesalinkBank['destination'], $pesalinkBank['transfer']);

        //swiftTransfer($dataSwift['source'], $dataSwift['destination'], $dataSwift['transfer']);

        //rtgsTransfer($dataRTGS['source'], $dataRTGS['destination'], $dataRTGS['transfer']);

        //transferToMobileWallet($dataMobile['source'], $dataMobile['destination'], $dataMobile['transfer']);

        //transferWithinEquityBank($dataBank['source'], $dataBank['destination'], $dataBank['transfer']);
    }
}
