<?php
    namespace app\Controllers;

    use app\core\Controller;
    use app\core\Request;
    use app\Models\Feedback;

    class PublicController extends Controller
    {
        public function home()
        {
            $this->setLayout('guest');
            return $this->render('home');
        }

        public function feedback(Request $request)
        {
            $model = new Feedback();
            if ($request->isPost()) {
//                var_dump($_POST);
                $userInput = $request->getBody();
                $model->loadData($userInput);
                if ($model->validate() && $model->save()) {
                    $this->setLayout('guest');
                    return $this->render('success', ['model'=> $model]);
                }
            }
//            var_dump($model);
            $this->setLayout('guest');
            return $this->render('home', ['model'=> $model]);
        }
    }
