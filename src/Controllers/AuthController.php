<?php

namespace Core\Controllers;

use Core\Models\User;
use Core\RedirectResponse;
use Core\Response;
use Core\Session;
use Core\Validation\Rules\NotEmptyRule;
use Core\Validation\Validator;

class AuthController extends Controller
{
    public function index(): Response
    {
        return $this->render('login');
    }

    public function login(): RedirectResponse
    {
        if (User::isLoggedIn()) {
            return $this->redirect('/');
        }

        $validator = new Validator([
            'username' => [new NotEmptyRule()],
            'password' => [new NotEmptyRule()],
        ]);
        $request = $this->app->request();

        if (!$validator->validate($request->getAll())) {
            return $this->redirect('/login');
        }

        $user = User::logIn($request->get('username'), $request->get('password'));

        if (!is_null($user)) {
            return $this->redirect('/');
        }

        Session::start()->set('login_error', 'Wrong username or password.');

        return $this->redirect('/login');
    }

    public function logOut(): RedirectResponse
    {
        User::logOut();

        return $this->redirect('/');
    }
}
