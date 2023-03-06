<?php

namespace App\Domain;

use DateTime;

class Message implements \JsonSerializable
{
    private ?int $id;
    private int $idChat;
    private int $idUserFrom;
    private string $text;
    private DateTime $dateCreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdUserFrom(): int
    {
        return $this->idUserFrom;
    }

    public function setIdUserFrom(int $idUserFrom): void
    {
        $this->idUserFrom = $idUserFrom;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getIdChat(): int
    {
        return $this->idChat;
    }

    public function setIdChat(int $idChat): void
    {
        $this->idChat = $idChat;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'idChat' => $this->idChat,
            'idUserFrom' => $this->idUserFrom,
            'text' => $this->text,
            'dateCreated' => $this->dateCreated->format('c'),
        ];
    }
}