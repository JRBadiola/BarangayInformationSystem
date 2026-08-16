<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ChatbotController extends ResourceController
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent';

    public function __construct()
    {
        $this->apiKey = getenv('GEMINI_API_KEY') ?: '';
        // Debug: Log if API key is loaded
        log_message('debug', 'Gemini API Key loaded: ' . (empty($this->apiKey) ? 'NO' : 'YES'));
    }

    /**
     * Handle chatbot message and get AI response
     */
    public function chat()
    {
        $message = $this->request->getPost('message');
        
        log_message('debug', 'Chat request received. Message: ' . $message);
        log_message('debug', 'API Key status: ' . (empty($this->apiKey) ? 'EMPTY' : 'LOADED'));
        
        if (empty($message)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'error' => 'Message is required'
            ]);
        }

        if (empty($this->apiKey)) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'API key not configured'
            ]);
        }

        try {
            $response = $this->callGeminiAPI($message);
            
            return $this->response->setJSON([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Chatbot error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to get response: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Call Gemini API using cURL
     */
    private function callGeminiAPI($message)
    {
        $url = $this->apiUrl . '?key=' . $this->apiKey;
        
        log_message('debug', 'Calling Gemini API URL: ' . $url);
        
        $systemInstruction = "You are the BIS Assistant for Barangay Bacolod, Bato, Camarines Sur. You are a specialized chatbot that ONLY answers questions about barangay services. 

Your role is to help residents with:
- Document requests (barangay clearance, certificate of residency, certificate of indigency, certificate of good moral, first time job seeker certificate)
- Account registration and login issues
- Blotter reports and filing complaints
- Census and household information
- Office hours and contact information
- Barangay procedures and requirements

IMPORTANT RULES:
1. ONLY answer questions related to barangay services
2. If asked about topics outside barangay services (weather, politics, entertainment, etc.), politely redirect to barangay-related topics
3. Provide specific, accurate information about Barangay Bacolod procedures
4. Keep responses concise and helpful
5. Office hours: Monday-Friday, 8:00 AM - 5:00 PM
6. Contact: Barangay Hall, Bacolod, Bato, Camarines Sur
7. Document processing time: 1-2 business days
8. Current date: " . date('F j, Y') . "
9. IMPORTANT: Format your response in PLAIN TEXT without markdown symbols like asterisks, hashtags, or backticks. Use simple text with line breaks.";
        
        $data = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'contents' => [
                [
                    'parts' => [
                        ['text' => $message]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024
            ]
        ];

        $jsonData = json_encode($data);
        log_message('debug', 'Request data: ' . $jsonData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for testing
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        log_message('debug', 'API Response HTTP Code: ' . $httpCode);
        log_message('debug', 'API Response: ' . $response);
        log_message('debug', 'cURL Error: ' . $error);

        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
        }

        if ($httpCode !== 200) {
            throw new \Exception('API returned HTTP code ' . $httpCode . '. Response: ' . $response);
        }

        $result = json_decode($response, true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $responseText = $result['candidates'][0]['content']['parts'][0]['text'];
            return $this->formatResponse($responseText);
        }

        throw new \Exception('Invalid API response format: ' . json_encode($result));
    }

    /**
     * Format response to remove markdown and clean up text
     */
    private function formatResponse($text)
    {
        // Remove markdown bold formatting
        $text = preg_replace('/\*\*(.*?)\*\*/', '$1', $text);
        $text = preg_replace('/\*(.*?)\*/', '$1', $text);
        
        // Remove markdown headers
        $text = preg_replace('/^#+\s*(.*)$/m', '$1', $text);
        
        // Remove code blocks
        $text = preg_replace('/```.*?```/s', '', $text);
        $text = preg_replace('/`([^`]+)`/', '$1', $text);
        
        // Clean up extra whitespace
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = trim($text);
        
        return $text;
    }

    /**
     * Save chat log to database
     */
    public function saveLog()
    {
        $residentId = $this->request->getPost('resident_id');
        $topic = $this->request->getPost('topic');
        $message = $this->request->getPost('message');
        $response = $this->request->getPost('response');
        $status = $this->request->getPost('status') ?? 'Resolved';

        $db = \Config\Database::connect();
        
        $data = [
            'resident_id' => $residentId,
            'topic' => $topic,
            'message' => $message,
            'response' => $response,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $db->table('chatbot_logs')->insert($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Log saved successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to save log: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get chat logs
     */
    public function getLogs()
    {
        $db = \Config\Database::connect();
        
        try {
            $logs = $db->table('chatbot_logs')
                ->orderBy('created_at', 'DESC')
                ->limit(50)
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                'success' => true,
                'logs' => $logs
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to fetch logs: ' . $e->getMessage()
            ]);
        }
    }
}
