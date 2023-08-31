<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HadaraSms{
    protected $baseUrl = "";
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function send($to, $message)
    {

        dd($to);
        $response = Http::baseUrl($this->baseUrl)
        ->withHeaders([
            "Authorization" => "Bearer ".$this->key
        ])
        ->withToken($this->key)
        ->get('sendmessage',[
            'apiKky' => $this->key,
            'to' => $to,
            'msg' => $message,
        ]);

        $json = $response->json();
    }
}