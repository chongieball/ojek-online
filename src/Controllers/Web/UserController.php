<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends \App\Controllers\BaseController
{
    public function home(Request $request, Response $response)
    {
        echo "user home";
    }

	public function getRegister(Request $request, Response $response)
    {
        return $this->view->render($response, 'users/register.twig');
    }

    public function postRegister(Request $request, Response $response)
    {
        $req = $request->getParams();

        $client = $this->request('POST', $this->router->pathFor('api.register'), ['json' => $req]);

        if (key($client) === 'errors') {
            if ($client['errors']['data']) {
                foreach ($client['errors']['data'] as $key => $value) {
                    $_SESSION['errors'][$key] = $value;
                }
            } else {
                $this->flash->addMessage('errors', $client['message']);
            }

            $_SESSION['old'] = $req;

            return $response->withRedirect($this->router->pathFor('web.register'));
        } else {
            $this->flash->addMessage('success', $client['message']);

            $_SESSION['temp']['resend_code']['username'] = $client['data']['username'];

            return $response->withRedirect($this->router->pathFor('web.activation'));
        }
    }

    public function getActivation(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/activate.twig');
    }

    public function postActivation(Request $request, Response $response)
    {
        $options = [
            'query' => [
                'token' => $request->getParam('token'),
            ]
        ];

        $client = $this->request('POST', $this->router->pathFor('api.activate'), $options);

        if (key($client) === 'errors') {
            if ($client['errors']['data']) {
                foreach ($client['errors']['data'] as $key => $value) {
                    $_SESSION['errors'][$key] = $value;
                }
            } else {
                $this->flash->addMessage('errors', $client['errors']['message']);
            }

            $_SESSION['old'] = $req;

            return $response->withRedirect($this->router->pathFor('web.activation'));
        } else {
            $this->flash->addMessage('success', $client['message']);

            unset($_SESSION['temp']['resend_code']);

            return $response->withRedirect($this->router->pathFor('web.login'));
        }
    }

    public function resendCode(Request $request, Response $response)
    {
    	$options = [
            'json'  => $_SESSION['temp']['resend_code'],
        ];

        $client = $this->request('POST', $this->router->pathFor('api.resend.code'), $options);

        if (key($client) === 'errors') {
            $this->flash->addMessage('errors', $client['errors']['message']);

        } else {
            $this->flash->addMessage('success', $client['message']);
        }
            return $response->withRedirect($this->router->pathFor('web.activation'));
    }

    public function getResetPassword(Request $request, Response $response)
    {
    	return $this->view->render($response, 'users/reset_password.twig');
    }

    public function postResetPassword(Request $request, Response $response)
    {
        $req = $request->getParams();

        $client = $this->request('POST', $this->router->pathFor('api.reset.password'), ['json' => $req]);

        if (key($client) === 'errors') {
            if ($client['errors']['data']) {
                foreach ($client['errors']['data'] as $key => $value) {
                    $_SESSION['errors'][$key] = $value;
                }
            } else {
                $this->flash->addMessage('errors', $client['errors']['message']);
            }

            $_SESSION['old'] = $req;

            return $response->withRedirect($this->router->pathFor('web.reset.password'));
        } else {
            $this->flash->addMessage('success', $client['message']);

            return $response->withRedirect($this->router->pathFor('web.login'));
        }
    }

    public function getRenewPassword(Request $request, Response $response)
    {
        $options = [
            'query' => [
                'token' => $request->getParam('token'),
            ]
        ];

        $client = $this->request('GET', $this->router->pathFor('api.get.renew.password'), $options);

        if (key($client) === 'errors') {
            $this->flash->addMessage('errors', $client['errors']['message']);

            return $response->withRedirect($this->router->pathFor('web.reset.password'));
        } else {
    	   return $this->view->render($response, 'users/renew_password.twig');
        }
    }

    public function postRenewPassword(Request $request, Response $response)
    {
    	$options = [
            'json'  => $request->getParams(),
            'query' => [
                'token' => $request->getQueryParam('token')
            ],
        ];

        $client = $this->request('PUT', $this->router->pathFor('api.put.renew.password'), $options);

        if (key($client) === 'errors') {
            if ($client['errors']['data']) {
                foreach ($client['errors']['data'] as $key => $value) {
                    $_SESSION['errors'][$key] = $value;
                }
            } else {
                $this->flash->addMessage('errors', $client['errors']['message']);
            }

            $_SESSION['old'] = $req;

            return $response->withRedirect($this->router->pathFor('web.renew.password').'?token='.$request->getQueryParam('token'));
        } else {
            $this->flash->addMessage('success', $client['message']);

            return $response->withRedirect($this->router->pathFor('web.login'));
        }
    }

    private function checkRoleAndRedirect()
    {
        if ($_SESSION['login']['role'] === 1) {
            return $this->response->withRedirect($this->router->pathFor('web.admin.home'));
        } elseif ($_SESSION['login']['role'] === 2) {
            return $this->response->withRedirect($this->router->pathFor('web.driver.home'));
        } else {
            return $this->response->withRedirect($this->router->pathFor('web.home'));
        }
    }

    public function getLogin(Request $request, Response $response)
    {
        if ($_SESSION['login']) {
            $this->flash->addMessage('errors', 'You have logged in');

            return $this->checkRoleAndRedirect();
        }
    	return $this->view->render($response, 'users/login.twig');
    }

    public function postLogin(Request $request, Response $response)
    {
    	$options = [
            'json'  => $request->getParams(),
        ];

        $client = $this->request('POST', $this->router->pathFor('api.login'), $options);

        if (key($client) === 'errors') {
            $this->flash->addMessage('errors', $client['errors']['message']);

            return $response->withRedirect($this->router->pathFor('web.login'));
        } else {
            $_SESSION['login'] = $client['data'];

            return $this->checkRoleAndRedirect();
        }
    }

    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['login']);

        return $response->withRedirect($this->router->pathFor('web.login'));
    }
}