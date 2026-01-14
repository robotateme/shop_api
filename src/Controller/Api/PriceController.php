<?php

namespace App\Controller\Api;

use App\Dto\CalculatePriceInputDto;
use App\Service\CalculatePriceScenario;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;

final class PriceController extends AbstractController
{
    /**
     * @param CalculatePriceScenario $calculatePrice
     */
    public function __construct(private readonly CalculatePriceScenario $calculatePrice)
    {
    }

    /**
     * @param CalculatePriceInputDto $calculatePriceInputDto
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/calculate-price', name: 'api_calculate_price', methods: 'POST')]
    public function calculate(
        #[MapRequestPayload] CalculatePriceInputDto $calculatePriceInputDto,
    ): JsonResponse
    {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->calculatePrice->handle($calculatePriceInputDto),
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
