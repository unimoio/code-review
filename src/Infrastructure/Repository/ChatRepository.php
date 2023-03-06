<?php

namespace App\Infrastructure\Repository;

use App\Domain\Chat;
use Framework\DB;

class ChatRepository
{
    private PDO $connection;
    private LoggerIntereface $logger;

    public function __construct()
    {
        $this->connection = DB::init();
        $this->logger = Container::get(LoggerIntereface::class);
    }

    public function findById(int $idChat): ?Chat
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM chat where id = $idChat");
            $stmt->execute();

            $response = $stmt->fetch();

            if ($response) {
                $chat = new Chat();
                $chat->setId($response['id']);
                $chat->setCountMessages($response['count_messages']);
                $chat->setDateCreated(new \DateTime($response['date_created']));

                return $chat;
            }
        } catch(\Throwable $e) {
            $this->logger->error('Error: ' . $e->getMessage(), [
                'id_chat' => $idChat,
            ]);
        }

        return null;
    }

    public function save(Chat $chat): Chat
    {
        $sql = <<<SQL
        INSERT INTO chat VALUES (:id, :count_messages, :date_created) 
        ON DUPLICATE KEY UPDATE count_messages=VALUES(count_messages) 
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $chat->getId(),
            'count_messages' => $chat->getCountMessages(),
            'date_created' => $chat->getDateCreated(),
        ]);

        if ($chat->getId() === null) {
            $chat->setId($this->connection->lastInsertId());
        }

        return $chat;
    }
}