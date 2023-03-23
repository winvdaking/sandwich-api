<?php

namespace auth\actions\signin;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use auth\services\utils\AccountService;

final class PostSigninAction
{

    private $secret = 's6Mn7HjCkn3GOnE3j6nSN1NeHQPm3WpdnzuaiXVymxBcZ9ZG5GhILeN9VErwxhe';

    public function __invoke(Request $request, Response $response, array $args): Response
    {

        if (!$request->hasHeader('Authorization')) {
            return $this->generateAuthentificationError($response);
        }

        $h = $request->getHeader('Authorization')[0];

        $tokenEncode = sscanf($h, "Basic %s")[0];
        $tokenDecode = base64_decode($tokenEncode, true);

        // base64_decode est en mode strict donc elle peut retourner false
        // si la chaine de caractère contient des caractères qui ne sont pas
        // acceptés par base64
        if ($tokenDecode === false) {
            return $this->generateAuthentificationError($response, 'Error processing token');
        }

        [$login, $password] = explode(':', $tokenDecode);

        $user = AccountService::getUserByUsername($login);

        if (is_null($user)) {
            return $this->generateAuthentificationError($response, 'User not found');
        }

        if (!password_verify($password, $user['userpswd'])) {
            return $this->generateAuthentificationError($response, 'Bad credentials');
        }

        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
            'uid' => $user['_id']->__toString(),
            'lvl' => $user['userlevel']
        ];

        $token = JWT::encode($payload, $this->secret, 'HS512');
        $refreshToken = $this->strRand(32);

        AccountService::updateRefreshToken($user['_id']->__toString(), $refreshToken);

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode([
            'access-token' => $token,
            'refresh-token' => $refreshToken
        ]));

        return $response;
    }

    private function generateAuthentificationError(Response $response, string $message = 'No authorization header present'): Response
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

    private function strRand(int $length = 64): string
    {
        $length = ($length < 4) ? 4 : $length;
        return bin2hex(random_bytes(($length-($length%2))/2));
    }
}
