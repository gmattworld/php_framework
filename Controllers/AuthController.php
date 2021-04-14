<?php

    namespace app\Controllers;

    use app\core\Controller;
    use app\core\Request;

    class AuthController extends Controller
    {
        public function register()
        {
            return $this->renderAPI('register', 'auth');
        }

        public function login(Request $request)
        {
            return $request->getBody();
            return $this->renderAPI('login', 'auth');
        }

        public function logout()
        {
            return $this->renderAPI('logout', 'auth');
        }
    }