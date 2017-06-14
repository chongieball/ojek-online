<?php 

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.register');
});