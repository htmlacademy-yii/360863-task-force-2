<?php

namespace app\controllers;

class LandingController extends AppController
{
    public $layout = 'landing';

    public function actionIndex (): string
    {
        $this->view->title = 'Главная страница'; /*и так тоже не передается Tilte*/
        return $this->render('index');
    }
}
