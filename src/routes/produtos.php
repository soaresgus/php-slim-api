<?php

use App\Models\Produto;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

//Routes

$app->group('/api/v1', function() {
    $this->get('/produtos/lista', function($request, $response) {
        $produtos = Produto::get();
        return $response->withJson([$produtos]);
    });

    $this->post('/produtos/adiciona', function($request, $response) {
        $dados = $request->getParsedBody();
        $produto = Produto::create( $dados );
        return $response->withJson( $produto );
    });

    $this->get('/produtos/lista/{id}', function($request, $response, $args) {
        $produtos = Produto::findOrFail($args['id']);
        return $response->withJson([$produtos]);
    });

    $this->put('/produtos/atualiza/{id}', function($request, $response, $args) {
        $dados = $request->getParsedBody();
        $produtos = Produto::findOrFail($args['id']);
        $produtos->update( $dados );
        return $response->withJson([$produtos]);
    });

    $this->delete('/produtos/remove/{id}', function($request, $response, $args) {
        $produtos = Produto::findOrFail($args['id']);
        $produtos->delete();
        return $response->withJson([$produtos]);
    });
});