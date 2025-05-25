<?php

namespace app\controllers;
use app\classes\View as View;
use app\controllers\auth\SessionController as SC;
use app\models\user as user;

class DoctoresController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    // public function index($params = null){
    //     $response = [
    //         'ua' => SC::sessionValidate() ?? [ 'sv' => 0 ],
    //         'title' => 'Consultorio Jade',
    //         'code' => 200
    //     ];
    //     View::render('lista',$response);
    // }

    public function doctores(){
        $doctores = new user();
        $result = $doctores->getAllUser();
        echo json_encode($result);
    }
}