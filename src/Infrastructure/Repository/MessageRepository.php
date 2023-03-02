<?php

namespace App\Infrastructure\Repository;

use App\Domain\Chat;
use App\Domain\Message;
use PDO;

class MessageRepository
{
    private PDO $connection;
    private LoggerIntereface $logger;

    public function __construct()
    {
        $this->connection = DB::init();
        $this->logger = Container::get(LoggerIntereface::class);
    }

    public function save(Message $message): Message
    {
        $sql = <<<SQL
        INSERT IGNORE INTO message VALUES (:id, :id_user, :id_chat, :text, :date_created)
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $message->getId(),
            'id_user' => $message->getIdUserFrom(),
            'id_chat' => $message->getIdChat(),
            'text' => $message->getIdChat(),
            'date_created' => $message->getDateCreated(),
        ]);

        if ($message->getId() === null) {
            $message->setId($this->connection->lastInsertId());
        }

        return $message;
    }

    public function findById(int $idMessage): ?Message
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM message where id = $idMessage");
            $stmt->execute();

            $response = $stmt->fetch();

            if ($response) {
                $message = new Message();
                $message->setId($response['id']);
                $message->setIdUserFrom($response['id_user']);
                $message->setIdChat($response['id_chat']);
                $message->setText($response['text']);
                $message->setDateCreated(new \DateTime($response['date_created']));

                return $message;
            }
        } catch (\Throwable $e) {
            $this->logger->error('Error: ' . $e->getMessage(), [
                'id_message' => $idMessage,
            ]);
        }

        return null;
    }

    public function findByChat(int $idChat): iterable
    {
        try {
            $stmt = $this->connection->prepare(
                "SELECT * FROM message where id_chat = $idChat ORDER BY date_created ASC"
            );
            $stmt->execute();

            foreach ($stmt->fetchAll() as $row) {
                $message = new Message();
                $message->setId($row['id']);
                $message->setIdUserFrom($row['id_user']);
                $message->setIdChat($row['id_chat']);
                $message->setText($row['text']);
                $message->setDateCreated(new \DateTime($row['date_created']));

                yield $message;
            }
        } catch (\Throwable $e) {
            $this->logger->error('Error: ' . $e->getMessage(), [
                'id_chat' => $idChat,
            ]);
        }
    }

    public function findByText(string $text): iterable
    {
        try {
            $stmt = $this->connection->prepare(
                "SELECT * FROM message where text LIKE '%$text%' ORDER BY date_created ASC"
            );
            $stmt->execute();

            foreach ($stmt->fetchAll() as $row) {
                $message = new Message();
                $message->setId($row['id']);
                $message->setIdUserFrom($row['id_user']);
                $message->setIdChat($row['id_chat']);
                $message->setText($row['text']);
                $message->setDateCreated(new \DateTime($row['date_created']));

                yield $message;
            }
        } catch (\Throwable $e) {
            $this->logger->error('Error: ' . $e->getMessage(), [
                'text' => $text,
            ]);
        }
    }
}