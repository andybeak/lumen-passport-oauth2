<?php

// default route
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// allow users to register
$router->post('/register','UsersController@register');

// routes that require authentication

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->get('/protected', function () {
        return response(['message' => 'Authenticated successfully']);
    });

});

