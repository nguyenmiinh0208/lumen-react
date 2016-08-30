<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => 'v1'], function () use ($app) {
    $app->get('/', ['as' => 'services.index', 'uses' => '\App\Http\Controllers\ServiceController@ping']);
    $app->get('/services/ping', ['as' => 'services.ping', 'uses' => '\App\Http\Controllers\ServiceController@ping']);

    $app->post('/oauth/client_access_token', ['as' => 'oauth.clientAccessToken', 'uses' => '\App\Http\Controllers\OAuthController@accessToken']);
});

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:generateAccessToken'], function () use ($app) {
    $app->post('/oauth/access_token', ['as' => 'oauth.accessToken', 'uses' => '\App\Http\Controllers\OAuthController@accessToken']);
});

// Protected endpoints
$app->group(['prefix' => 'v1', 'middleware' => 'oauth:resourceOwnerAccount'], function () use ($app) {
    $app->get('/account', ['as' => 'account.index', 'uses' => '\App\Http\Controllers\AccountController@index']);
});

$app->get('/', ['as' => 'home.index', 'uses' => 'ServiceController@ping']);
