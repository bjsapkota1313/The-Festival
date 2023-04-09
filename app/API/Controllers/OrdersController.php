<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../Services/ApiKeyService.php';

class OrdersController extends ApiController
{
    private $apiKeyService;

    public function __construct()
    {
        $this->apiKeyService = new ApiKeyService();
    }

    public function index()
    {
        $apiKey = $this->getAPiKeyFromHeader();
        if (empty($apiKey)) {
            $this->respondWithError(401, 'API key is required In order to access this resource');
            return;
        }
        if (!$this->apiKeyService->isApiKeyValid($apiKey)) {
            $this->respondWithError(401, 'API key is invalid');
            return;
        }

    }

    private function getAPiKeyFromHeader()
    {
        return $_SERVER['HTTP_APIKEY'] ?? null;
    }
}