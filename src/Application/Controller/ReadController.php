<?php

namespace App\Application\Controller;

use App\Domain\UseCase\ReadChatUseCase;
use Framework\AbstractController;
use Framework\Request;

class ReadController extends AbstractController
{
    public function __invoke(Request $request)
    {
        /** @var ReadChatUseCase $useCase */
        $useCase = Container::get(ReadChatUseCase::class);
        $response = [];
        foreach ($useCase->__invoke($request->get('id_chat')) as $message) {
            $response[] = $message;
        }

        return json_encode($response);
    }
}