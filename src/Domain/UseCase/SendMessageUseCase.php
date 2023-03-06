<?php

namespace App\Domain\UseCase;

use App\Domain\Chat;
use App\Domain\Message;
use App\Infrastructure\Repository\ChatRepository;
use App\Infrastructure\Repository\MessageRepository;
use DateTime;
use Framework\Container;

class SendMessageUseCase
{
    private ChatRepository $chatRepository;
    private MessageRepository $messageRepository;

    public function __construct()
    {
        $this->chatRepository = Container::get(ChatRepository::class);
        $this->messageRepository = Container::get(MessageRepository::class);
    }

    public function __invoke(int $idSender, int $idChat, string $text): Message
    {
        $chat = $this->chatRepository->findById($idChat);
        $message = new Message();
        $message->setIdChat($chat->getId());
        $message->setIdUserFrom($idSender);
        $message->setText($text);
        $message->setDateCreated(new DateTime());
        $chat->setCountMessages($chat->getCountMessages() + 1);
        $this->messageRepository->save($message);
        $this->chatRepository->save($chat);

        return $message;
    }
}