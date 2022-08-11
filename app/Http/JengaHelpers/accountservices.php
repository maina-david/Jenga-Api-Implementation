<?php

use App\Models\JengaToken;
use App\Jobs\GenerateJengaToken;
use Illuminate\Support\Facades\Http;

/**
 * Get Jenga token.
 *
 * @return \Illuminate\Http\Response
 */
function jengaToken()
{
    $token = JengaToken::first();
    if (!$token) {
        dispatch(new GenerateJengaToken);

        $token = JengaToken::first();
        if ($token) {
            return $token->access_token;
        }

        return null;
    }
    //Check if the token exixts and has expired. If it has, refresh the token.
    if ($token && time() > $token->expires_in) {
        dispatch(new GenerateJengaToken);

        $token = JengaToken::first();
        if ($token) {
            return $token->access_token;
        }

        return null;
    }
    return $token->access_token;
}

/**
 * Check Account Balance.
 *
 * @return \Illuminate\Http\Response
 */
function accountBalance($countryCode, $accountId)
{
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $url = config('jenga.base_url') . '/account-api/v3.0/accounts/balances/' . $countryCode . '/' . $accountId;

    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($countryCode . $accountId),
    ];
    $response = Http::withHeaders($headers)->get($url);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response->balance;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Account Ministatement.
 *
 * @return \Illuminate\Http\Response
 */
function accountMinistatement($countryCode, $accountId)
{
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $url = config('jenga.base_url') . '/account-api/v3.0/accounts/ministatement/' . $countryCode . '/' . $accountId;
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($countryCode . $accountId),
    ];
    $response = Http::withHeaders($headers)->get($url);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Full Account Statement.
 *
 * @return \Illuminate\Http\Response
 */
function accountFullStatement($countryCode, $accountId, $fromDate, $toDate, $limit = 3)
{
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $url = config('jenga.base_url') . '/account-api/v3.0/accounts/fullstatement';
    $body = [
        'countryCode' => $countryCode,
        'accountId' => $accountId,
        'fromDate' => $fromDate,
        'toDate' => $toDate,
        'limit' => $limit,
    ];
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($countryCode . $accountId . $fromDate . $toDate, $limit),
    ];
    $response = Http::withHeaders($headers)->post($url, $body);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Opening and Closing Balance.
 *
 * @return \Illuminate\Http\Response
 */
function accountOpeningClosingBalance($countryCode, $accountId, $date)
{
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $url = config('jenga.base_url') . '/account-api/v3.0/accounts/accountbalance/query';
    $body = [
        'countryCode' => $countryCode,
        'accountId' => $accountId,
        'date' => $date,
    ];
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($countryCode . $accountId . $date),
    ];
    $response = Http::withHeaders($headers)->post($url, $body);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Account Enquiry.
 *
 * @return \Illuminate\Http\Response
 */
function accountEnquiry($countryCode, $accountId)
{
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $url = config('jenga.base_url') . '/account-api/v3.0/accounts/enquiry/' . $countryCode . '/' . $accountId;
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($countryCode . $accountId),
    ];
    $response = Http::withHeaders($headers)->get($url);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Generate Signature.
 *
 * @return \Illuminate\Http\Response
 */
function generateSignature($data)
{
    $plainText  = $data;
    $privateKey = openssl_pkey_get_private(file_get_contents(storage_path('app/keys/privatekey.pem')));
    openssl_sign($plainText, $signature, $privateKey, OPENSSL_ALGO_SHA256);

    return base64_encode($signature);
}
