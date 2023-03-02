<?php

namespace App\Domain\UseCase;

use App\Infrastructure\Repository\MessageRepository;
use Framework\Container;

class ReadChatUseCase
{
    private MessageRepository $messageRepository;

    public function __construct()
    {
        $this->messageRepository = Container::get(MessageRepository::class);
    }

    public function __invoke(int $idChat): iterable
    {
        return $this->messageRepository->findByChat($idChat);
    }
}