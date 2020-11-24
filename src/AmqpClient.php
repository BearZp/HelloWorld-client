<?php declare(strict_types=1);

namespace Client;

use Lib\protocol\AmqpProtocol;
use Lib\protocol\ProtocolInterface;
use Lib\protocol\ProtocolPacketInterface;
use Lib\queues\rabbitMq\LazyRabbitMqConnectionProvider;

class AmqpClient implements ProtocolInterface
{
    /**
     * @var AmqpProtocol
     */
    private $protocol;

    /**
     * AmqpClient constructor.
     * @param LazyRabbitMqConnectionProvider $connection
     * @param string $queueName
     * @param int $clientTimeout
     */
    public function __construct(LazyRabbitMqConnectionProvider $connection, string $queueName, int $clientTimeout)
    {
        $this->protocol = new AmqpProtocol(
            $connection,
            $queueName,
            $clientTimeout
        );
    }

    /**
     * @param ProtocolPacketInterface $packet
     * @return ProtocolPacketInterface
     * @throws \Exception
     */
    public function sendPacket(ProtocolPacketInterface $packet): ProtocolPacketInterface
    {
        return $this->protocol->sendPacket($packet);
    }

    /**
     * @param ProtocolPacketInterface $packet
     * @throws \Exception
     */
    public function pushPacket(ProtocolPacketInterface $packet): void
    {
        $this->protocol->pushPacket($packet);
    }
}