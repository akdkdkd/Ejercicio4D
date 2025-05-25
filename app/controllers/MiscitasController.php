<?php

namespace app\controllers;
use app\classes\View as View;
use app\controllers\auth\SessionController as SC;
use app\models\pacientes;
use app\models\user as user;


class MiscitasController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index($params = null){
        $response = [
            'ua' => SC::sessionValidate() ?? [ 'sv' => 0 ],
            'title' => 'Consultorio Jade',
            'code' => 200
        ];
        View::render('Miscitas',$response);
    }

}