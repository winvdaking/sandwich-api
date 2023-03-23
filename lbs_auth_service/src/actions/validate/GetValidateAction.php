<?php

namespace auth\actions\validate;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use auth\services\utils\AccountService;

final class GetValidateAction
{

    private $secret = 's6Mn7HjCkn3GOnE3j6nSN1NeHQPm3WpdnzuaiXVymxBcZ9ZG5GhILeN9VErwxhe';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return $this->generateAuthentificationError($response);
        }

        $h = $request->getHeader('Authorization')[0];

        $tokenEncode = sscanf($h, "Bearer %s")[0];

        try {
            $tokenDecode = JWT::decode($tokenEncode,  new Key($this->secret, 'HS512'));
        } catch (ExpiredException $e) {
            return $this->generateAuthentificationError($response, $e->getMessage());
        } catch (SignatureInvalidException $e) {
            return $this->generateAuthentificationError($response, $e->getMessage());
        } catch (BeforeValidException $e) {
            return $this->generateAuthentificationError($response, $e->getMessage());
        } catch (\UnexpectedValueException $e) {
            return $this->generateAuthentificationError($response, $e->getMessage());
        }

        if (!isset($tokenDecode->uid)) {
            return $this->generateAuthentificationError($response, 'None user id found in the token');
        }

        $userId = $tokenDecode->uid;
        
        $user = AccountService::getUserById($userId, [
            'username' => 1,
            'usermail' => 1,
            'userlevel' => 1,
            '_id' => 0
        ]);

        if (is_null($user)) {
            return $this->generateAuthentificationError($response, 'User not found');
        }

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($user));

        return $response;

    }

    private function generateAuthentificationError(Response $response, string $message = "no authorization header present"): Response
    {
        $data = [
            "type" => "error",
            "error" => 401,
            "message" => $message
        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(401);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
