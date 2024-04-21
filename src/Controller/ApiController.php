<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    public function successResponse(array|JsonResponse|null $data=[]): JsonResponse
    {
        $response= [
            'success' => true,
            'data' => $data
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }
    public function errorResponse(array|JsonResponse $data=[]): JsonResponse
    {
        $response= [
            'success' => false,
            'data' => $data];

        return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
