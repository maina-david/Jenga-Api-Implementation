<?php

use Illuminate\Support\Facades\Http;

/**
 * Transfer within Equity Bank.
 *
 * @return \Illuminate\Http\Response
 */
function transferWithinEquityBank($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/internalBankTransfer';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Transfer to Mobile Wallet.
 *
 * @return \Illuminate\Http\Response
 */
function transferToMobileWallet($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/sendmobile';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * RTGS Transfer.
 *
 * @return \Illuminate\Http\Response
 */
function rtgsTransfer($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/rtgs';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * SWIFT Transfer.
 *
 * @return \Illuminate\Http\Response
 */
function swiftTransfer($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/swift';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Pesalink Transfer to Bank.
 *
 * @return \Illuminate\Http\Response
 */
function pesalinkTransferToBank($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/pesalinkacc';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}

/**
 * Pesalink Transfer to Mobile.
 *
 * @return \Illuminate\Http\Response
 */
function pesalinkTransferToMobile($source = array(), $destination =  array(), $transfer = array())
{
    $url = config('jenga.base_url') . '/transaction-api/v3.0/remittance/pesalinkmobile';
    $data = [
        "source" => $source,
        "destination" => $destination,
        "transfer" => $transfer
    ];
    $token = jengaToken();
    if (!$token) {
        return null;
    }
    $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
        'signature' => generateSignature($data),
    ];
    $response = Http::withHeaders($headers)->post($url, $data);
    if ($response->successful()) {
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    return json_decode($response->getBody()->getContents());
}
