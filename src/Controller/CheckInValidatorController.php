<?php

namespace App\Controller;

use App\Factory\CheckInFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/validator")
 */
class CheckInValidatorController extends AbstractController
{

    /**
     * @Route("/check-in/form", name="validator_check_in_form", methods={"POST"})
     * @param Request $request
     * @param CheckInFactory $checkInFactory
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function formValidator(Request $request, CheckInFactory $checkInFactory, ValidatorInterface $validator): JsonResponse
    {
        $errorsForResponse = [];
        $content = json_decode($request->getContent(), true);

        if(!isset($content['_token']) || empty($content['_token'])) {
            return new JsonResponse(['message' => 'Token non fourni.'], Response::HTTP_FORBIDDEN);
        }

        if(!$this->isCsrfTokenValid('check_in_form', $content['_token'])) {
            return new JsonResponse(['message' => 'Token invalide.'], Response::HTTP_FORBIDDEN);
        }

        $checkIn = $checkInFactory->fromArray($content);
        $errors = $validator->validate($checkIn);

        foreach ($errors as $error) {
            if(method_exists($checkIn,'get' . ucfirst($error->getPropertyPath()))
                && $checkIn->{'get' . ucfirst($error->getPropertyPath())}() !== null) {
                array_push($errorsForResponse, $error->getMessage());
            }
        }

        return new JsonResponse($errorsForResponse, Response::HTTP_OK);
    }

}