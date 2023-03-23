<?php

namespace auth\services\utils;

use \auth\utils\MongoClient;

final class AccountService {

    public static function getUserByUsername(string $username): ?\MongoDB\Model\BSONDocument
    {
        $collection = (new MongoClient())->getCollection('User');
        $cursor = $collection->findOne([ 'username' => $username ]);
        return $cursor ?? null;
    }

    public static function getUserById(string $id, array $projection = []): ?\MongoDB\Model\BSONDocument
    {
        $collection = (new MongoClient())->getCollection('User');
        $cursor = $collection->findOne(
            [ '_id' => new \MongoDB\BSON\ObjectId($id) ],
            [ 'projection' => $projection ]
        );
        return $cursor ?? null;
    }

    public static function updateRefreshToken(string $id, string $refreshToken): void
    {
        $collection = (new MongoClient())->getCollection('User');
        $collection->updateOne(
            [ '_id' => new \MongoDB\BSON\ObjectId($id) ],
            [ '$set' => [ 'refresh_token' => $refreshToken ]]
        );
    }

}
