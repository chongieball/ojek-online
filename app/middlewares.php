<?php

use Slim\Container;
use Slim\Middleware\JwtAuthentication;

$whiteListJwt = ['/', '/login', '/register', '/activate', 'resend_code'];

$container['jwt'] = function (Container $container) {
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