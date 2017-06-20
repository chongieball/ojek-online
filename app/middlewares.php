<?php

use Slim\Container;
use Slim\Middleware\JwtAuthentication;

$whiteListJwt = [];

$container['jwt'] = function (Container $container) use ($whiteListJwt) {
	$setting = $container->get('settings')['jwt'];
	return new JwtAuthentication([
		'path'			=> '/api',
		'passthrough'	=> $whiteListJwt,
		'attribute'		=> 'token',
		'secret'		=> $setting['token'],
		'callback' 		=> function ($req, $res, $args) use ($container) {
		            $container['token'] = $args['decoded'];
		},
	]);
};

$app->add("jwt");