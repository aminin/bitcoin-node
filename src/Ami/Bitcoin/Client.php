<?php

namespace Ami\Bitcoin;

use Denpa\Bitcoin\Client as BitcoinClient;

class Client
{
    /** @var BitcoinClient */
    private $client;

    public function __construct(...$args)
    {
        $this->client = new BitcoinClient(...$args);
    }

    public function __call(string $method, array $params = [])
    {
        $data  = $this->client->__call($method, $params);
        return json_decode($data->getBody(), true)['result'];
    }
}
