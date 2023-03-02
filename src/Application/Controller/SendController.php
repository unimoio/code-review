<?php

namespace App\Application\Controller;

use App\Domain\UseCase\SendMessageUseCase;
use Framework\AbstractController;
use Framework\Request;

class SendController extends PrivateAbstractController
{
    public function __invoke(int $idCurrentUser, Request $request)
    {
        /** @var SendMessageUseCase $useCase */
        $useCase = Container::get(SendMessageUseCase::class);
        return json_encode(
            $useCase->__invoke(
                $idCurrentUser,
                $request->get('id_chat'),
                $request->get('text'),
            )
        );
    }
}