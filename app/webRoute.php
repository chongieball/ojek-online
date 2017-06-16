<?php 

$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.register');
$app->post('/register', 'App\Controllers\Web\UserController:postRegister');

$app->get('/activation', 'App\Controllers\Web\UserController:getActivation')->setName('web.activation');
$app->post('/activation', 'App\Controllers\Web\UserController:postActivation');

$app->get('/resend-code', 'App\Controllers\Web\UserController:getResendCode')->setName('web.resend.code');

$app->get('/reset-password', 'App\Controllers\Web\UserController:getResetPassword')->setName('web.reset.password');
$app->post('/reset-password', 'App\Controllers\Web\UserController:postResetPassword');

$app->get('/renew-password', 'App\Controllers\Web\UserController:getRenewPassword')->setName('web.renew.password');
$app->post('/renew-password', 'App\Controllers\Web\UserController:postRenewPassword');

$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.login');
$app->post('/login', 'App\Controllers\Web\UserController:postLogin');