<?php
require_once __DIR__ . '/ApiController.php';
require_once __DIR__ . '/../../Services/ApiKeyService.php';
require_once __DIR__ . '/../../services/OrderService.php';
class OrdersController extends ApiController
{
    private $apiKeyService;
    private $orderService;

    public function __construct()
    {
        $this->apiKeyService = new ApiKeyService();
        $this->orderService = new OrderService();
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
        $orders = $this->orderService->getAllOrders();

    }

    private function getAPiKeyFromHeader()
    {
        return $_SERVER['HTTP_APIKEY'] ?? null;
    }
}