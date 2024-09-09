<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhacenterService
{
    protected string $to;
    protected string $file;
    protected array $lines = [];
    protected string $appKey;
    protected string $authKey;
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function to(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function file(string $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function line(string $line): self
    {
        $this->lines[] = $line;
        return $this;
    }

    public function send(): mixed
    {
        if (empty($this->to) || empty($this->lines || empty($this->file))) {
            throw new \Exception('Message is not correct.');
        }
        $message = implode("\n", $this->lines);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.wapanels.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => env('WA_APP_KEY'),
                'authkey' => env('WA_AUTH_KEY'),
                'to' => $this->to,
                'file' => $this->file,
                'message' => $message,
                'sandbox' => 'false'
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
