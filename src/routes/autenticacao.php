<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;
use App\Models\Usuario;
use \Firebase\JWT\JWT;

$app->post('/api/token', function($request, $response) { 
    $dados = $request->getParsedBody();

    $email = $dados['email'] ?? null;
    $senha = $dados['senha'] ?? null;

    $usuario = Usuario::where('email', $email)->first();

    if(!is_null($usuario) && (md5($senha) === $usuario->senha)) {
        $secretKey = $this->get('settings')['secretKey'];
        $token = JWT::encode([$usuario], $secretKey, 'HS256');

        return $response->withJson([
            'chave' => $token
        ]);
    }

    return $response->withJson([
        'status' => 'erro'
    ], 401);
});