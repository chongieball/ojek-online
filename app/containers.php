<?php

use Slim\Container;
use Slim\Views\Twig as View;
use Slim\Views\TwigExtension as ViewExt;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Slim\Middleware\JwtAuthentication;

$container = $app->getContainer();

$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
		$config);

	return $connect;
};

$container['validator'] = function (Container $container) {
	$setting = $container->get('settings')['lang']['default'];
	$params = $container['request']->getParams();

	return new \Valitron\Validator($params, [], $setting);
};

$container['view'] = function (Container $container) {
	$setting = $container->get('settings')['view'];

	$view = new View($setting['path'], $setting['twig']);
	$view->addExtension(new ViewExt($container->router, $container->request->getUri()));

	$view->getEnvironment()->addGlobal('flash', $container->flash);

	$view->getEnvironment()->addGlobal('baseUrl', $container->request->getUri()->getHost());

	if (isset($_SESSION['login'])) {
        $view->getEnvironment()->addGlobal('login', $_SESSION['login']);
    }

    if (isset($_SESSION['errors'])) {
        $view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        
        unset($_SESSION['errors']);
    }

    if ($_SESSION['old']) {
		$view->getEnvironment()->addGlobal('old', $_SESSION['old']);
		
		unset($_SESSION['old']);
	}

	return $view;
};

$container['flash'] = function (Container $container) {
	return new \Slim\Flash\Messages;
};

$container['mailer'] = function (Container $container) {
	$setting = $container->get('settings')['mailer'];

	$mailer = new \PHPMailer;
	$mailer->isSMTP();
	$mailer->isHTML(true);
	$mailer->Host = $setting['host'];
	$mailer->Port = $setting['port'];
	$mailer->SMTPSecure = $setting['smtp_secure'];
	$mailer->SMTPAuth = $setting['smtp_auth'];
	$mailer->Username = $setting['username'];
	$mailer->Password = $setting['password'];

	$mailer->setFrom($setting['username'], $setting['name']);

	return new \App\Extensions\Mailers\Mailer($container['view'], $mailer);
};

$container['testing'] = function (Container $container) {
	$setting = $container->get('settings')['guzzle'];
	return new Client(['base_uri' => $setting['base_uri'], 'headers' => $setting['headers']]);
};

$container['logger'] = function(Container $container) {
    $logger = new \Monolog\Logger('logger');

    return $logger;
};

$container["token"] = function ($container) {
    return new StdClass;
};

$container['jwt'] = function (Container $container) {
	$setting = $container->get('settings')['jwt'];
	return new JwtAuthentication([
		'path'			=> '/api',
		'passthrough'	=> ['/', '/login', '/register'],
		'attribute'		=> 'token',
		'secret'		=> $setting['token'],
		'callback' 		=> function ($req, $res, $args) use ($container) {
		            $container['token'] = $args['decoded'];
		},
	]);
};

Veritrans_Config::$serverKey = $container->get('settings')['payment-gateway']['server_key'];
Veritrans_Config::$isProduction = $container->get('settings')['payment-gateway']['is_live'];