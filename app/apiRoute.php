<?php 

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.register');

	$app->post('/activation', 'App\Controllers\Api\UserController:activate')->setName('api.activate');

	$app->post('/resend_code', 'App\Controllers\Api\UserController:resendCode')->setName('api.resend.code');

	$app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.login');
});