<?php

namespace app\controllers;
use app\classes\View as View;
use app\controllers\auth\SessionController as SC;
use app\models\pacientes;
use app\models\user as user;


class HomeController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index($params = null){
        $response = [
            'ua' => SC::sessionValidate() ?? [ 'sv' => 0 ],
            'title' => 'Consultorio Jade',
            'code' => 200
        ];
        View::render('home',$response);
    }

    public function getHome(){
        $doctores = new user();
        $result = $doctores->getUser();
        $pacientes = new pacientes();
        $result2 = $pacientes->getAllPacientes();
        echo json_encode(array_merge(json_decode($result), json_decode($result2)));
    }
}