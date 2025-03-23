<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ChatController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function index()
    {
        return view('welcome');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $description = $request->input('description');

        // AI Prompt
        $prompt = "Generate the most attractive, SEO-friendly, and catchy title for the following content: $description. The title should be concise (max 15-20 characters), engaging, and optimized for search engines. Include emojis if relevant to enhance appeal.  Provide the response only as a list of multiple top-performing title options, separated by a delimiter ',' without any brackets or extra text.";

        // API Call
        $response = Http::post("{$this->apiUrl}?key={$this->apiKey}", [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ]);
        // dd($response->json());
        if ($response->failed()) {
            return response()->json(['error' => 'AI request failed!'], 500);
        }

        $data = $response->json();
        $generatedTitle = $data['candidates'][0]['content']['parts'][0]['text'] ?? "No response from AI.";

        $titles = explode(",", $generatedTitle);
        $titles = array_filter(array_map('trim', $titles)); // Clean up empty spaces
    
        return response()->json(['titles' => $titles]);
    }
}
