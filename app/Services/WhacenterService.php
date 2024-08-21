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
        $this->appKey = env('WA_APP_KEY');
        $this->authKey = env('WA_AUTH_KEY');
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

        $response = $this->client->post('https://app.wapanels.com/api/create-message', [
            'form_params' => [
                'appkey' => $this->appKey,
                'authkey' => $this->authKey,
                'to' => $this->to,
                'file' => $this->file,
                'message' => $message,
                'sandbox' => 'true'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
