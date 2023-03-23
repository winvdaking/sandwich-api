<?php

namespace auth\utils;

use MongoDB\Client;
use MongoDB\Collection;

final class MongoClient {

    private Client $client;
    private array|bool $config;

    public function __construct() {
        $this->config = parse_ini_file(realpath(__DIR__ . '/../../config/config.db.ini'));
    }

    public function getClient(): Client
    {

        if (isset($this->client)) {
            return $this->client;
        }

        $this->client = new Client("mongodb://{$this->config['username']}:{$this->config['password']}@{$this->config['host']}");
        
        return $this->client;
    }

    public function getCollection(string $collection): Collection
    {
        $client = $this->getClient();
        $db = $client->auth;
        return $db->$collection;
    }

}
