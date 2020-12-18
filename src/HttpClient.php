<?php

namespace Client;

use Lib\protocol\AmqpProtocol;
use Lib\protocol\HttpProtocol;
use Lib\protocol\ProtocolInterface;
use Lib\protocol\ProtocolPacketInterface;
use Lib\queues\rabbitMq\LazyRabbitMqConnectionProvider;
use Lib\transport\HttpConnectionProvider;
use Lib\transport\HttpSwooleRpcClient;

class HttpClient implements ProtocolInterface
{
    /**
     * @var HttpProtocol
     */
    private $protocol;

    /**
     * AmqpClient constructor.
     * @param HttpConnectionProvider $connection
     * @param string $queueName
     * @param int $clientTimeout
     */
    public function __construct(HttpConnectionProvider $connection, int $clientTimeout)
    {
        $this->protocol = new HttpProtocol($connection, $clientTimeout);
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