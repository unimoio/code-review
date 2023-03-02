<?php

namespace App\Domain;

use DateTime;

class Chat implements \JsonSerializable
{
    private ?int $id;
    private DateTime $dateCreated;
    private int $countMessages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getCountMessages(): int
    {
        return $this->countMessages;
    }

    public function setCountMessages(int $countMessages): void
    {
        $this->countMessages = $countMessages;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'dateCreated' => $this->dateCreated->format('c'),
            'countMessages' => $this->countMessages,
        ];
    }
}