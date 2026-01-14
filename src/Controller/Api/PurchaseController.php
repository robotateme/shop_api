<?php

namespace App\Controller\Api;

use App\Dto\PurchaseInputDto;
use App\Service\CalculatePriceScenario;
use App\Service\PurchaseScenario;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;

final class PurchaseController extends AbstractController
{
    public function __construct(
        private readonly CalculatePriceScenario $calculatePriceScenario,
        private readonly PurchaseScenario       $purchaseScenario,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/purchase', name: 'api_purchase', methods: 'POST')]
    public function index(
        #[MapRequestPayload] PurchaseInputDto $purchaseInput,
    ): JsonResponse{
        try {
            $resultData = $this->calculatePriceScenario
                ->handle($purchaseInput);
            return $this->json([
                'success' => $this->purchaseScenario->handle($resultData, $purchaseInput->paymentProcessor),
                'data' => $resultData,
            ]);

        } catch (Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
