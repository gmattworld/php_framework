<?php

    namespace app\Controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\Models\User;

    class AuthController extends Controller
    {
        public function register(Request $request)
        {
            try {
                $model = new User();
                $model->loadData($request->getBody());
                if ($model->validate() && $model->save()) {
                    Application::$app->response->setStatusCode(201);
                    return $this->renderAPI($model);
                }
                Application::$app->response->setStatusCode(400);
                return $this->renderAPI($model->errors);
            }
            catch (Exception $e) {
                // Log error message
                Application::$app->response->setStatusCode(500);
                return $this->renderAPI(['error'=>'Server error']);
            }
        }

        public function login(Request $request)
        {
            try {
                $model = new User();
                $model->loadData($request->getBody());
                $user = $model->login();
                if ($user !== null) {
                    // Generate token
                    $token = "test_token";
                    Application::$app->response->setStatusCode(200);
                    return $this->renderAPI(['data'=> $user, 'token'=>$token]);
                }
                Application::$app->response->setStatusCode(400);
                return $this->renderAPI($model->errors);
            }
            catch (Exception $e) {
                // Log error message
                Application::$app->response->setStatusCode(500);
                return $this->renderAPI(['error'=>'Server error']);
            }
        }

        public function logout(Request $request)
        {
            try {
                // Check header for Authorization token
                $headers = apache_request_headers();
                if (!empty($headers)){
                    // Check authorization header

                }

                Application::$app->response->setStatusCode(200);
                return $this->renderAPI([]);
            }
            catch (Exception $e) {
                // Log error message
                Application::$app->response->setStatusCode(500);
                return $this->renderAPI(['error'=>'Server error']);
            }
        }
    }