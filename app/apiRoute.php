<?php 

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.register');

	$app->post('/activation', 'App\Controllers\Api\UserController:activation')->setName('api.activate');

	$app->post('/resend_code', 'App\Controllers\Api\UserController:resendCode')->setName('api.resend.code');

	$app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.login');

	$app->post('/reset-password', 'App\Controllers\Api\UserController:resetPassword')->setName('api.reset.password');

	$app->get('/renew-password', 'App\Controllers\Api\UserController:getRenewPassword')->setName('api.get.renew.password');
	$app->put('/renew-password', 'App\Controllers\Api\UserController:putRenewPassword')->setName('api.put.renew.password');

	$app->group('/admin', function() use ($app, $container) {
		$app->post('/set-price', 'App\Controllers\Api\AdminController:setPricePerKm')->setName('api.set.price');
	})->add(new \App\Middlewares\Api\AdminMiddleware($container));
});