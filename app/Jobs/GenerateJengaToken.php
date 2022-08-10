<?php

namespace App\Jobs;

use App\Models\JengaAccount;
use App\Models\JengaToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GenerateJengaToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jengaAccount;
    protected $jengaToken;
    protected $url;
    protected $headers;
    protected $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jengaAccount = JengaAccount::where('active', 1)->first();
        $this->jengaToken = JengaToken::orderBy('id', 'desc')->first();
        $this->url = config('jenga.url') . '/authenticate/merchant';
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Api-Key' => $this->jengaAccount->api_key,
        ];
        $this->body = [
            'merchantCode' => $this->jengaAccount->merchant_code,
            'consumerSecret' => $this->jengaAccount->consumer_secret,
        ];
    }

    /**
     * Execute the job. This should run every 10 minutes as the token expires within 15 minutes.
     *
     * @return void
     */
    public function handle()
    {
        //Check if any tokens exist in the database. If not, create one.
        if (!$this->jengaToken) {
            $response = Http::withHeaders($this->headers)->post($this->url, $this->body);
            if ($response->successful()) {
                $response = json_decode($response->getBody()->getContents());
                $jengaToken = new JengaToken();
                $jengaToken->merchant_code = $this->jengaAccount->merchant_code;
                $jengaToken->access_token = $response->accessToken;
                $jengaToken->refresh_token = $response->refreshToken;
                $jengaToken->expires_in = strtotime($response->expiresIn);
                $jengaToken->issued_at = strtotime($response->issuedAt);
                $jengaToken->token_type = $response->tokenType;
                $jengaToken->save();
            }
            $this->release();
        } else {
            //Check if the token has expired. If it has, refresh the token.
            if (time() > $this->jengaToken->expires_in) {
                $response = Http::withHeaders($this->headers)->post($this->url, $this->body);
                if ($response->successful()) {
                    $response = json_decode($response->getBody()->getContents());
                    $jengaToken = JengaToken::find($this->jengaToken->id);
                    $jengaToken->access_token = $response->accessToken;
                    $jengaToken->refresh_token = $response->refreshToken;
                    $jengaToken->expires_in = strtotime($response->expiresIn);
                    $jengaToken->issued_at = strtotime($response->issuedAt);
                    $jengaToken->token_type = $response->tokenType;
                    $jengaToken->save();
                }
                $this->release();
            }
        }
    }
}
