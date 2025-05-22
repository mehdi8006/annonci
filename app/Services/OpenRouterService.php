<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenRouterService
{
    protected $apiKey;
    protected $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('OPENROUTER_API_KEY');
    }

    public function isRespectful($text)
    {
        $prompt = "Le texte suivant est-il respectueux ? Réponds seulement par 'Oui' ou 'Non'. Texte : \"$text\"";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'HTTP-Referer' => 'https://votresite.com', // obligatoire pour OpenRouter
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => 'openai/gpt-3.5-turbo', // ou autre modèle pris en charge
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ]
        ]);

        if ($response->successful()) {
            $content = $response['choices'][0]['message']['content'];
            return str_contains(strtolower($content), 'oui');
        }

        return false; // ou lever une exception si tu préfères
    }
}
