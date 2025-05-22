<?php

namespace app\controllers;

use app\models\posts as posts;
use app\models\comments as comments;
use app\models\citas as citas;
use app\models\interactions as inter;

class CitasController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){}

public function getqcitas($params = null){
    if (!isset($params[2])) {
        echo json_encode([]); // o mensaje de error
        return;
    }

    $did = $params[2];
    $citas = new citas();
    echo $citas->getCitas($did);
}

public function getcitas($params = null){
    $citas = new citas();
    $ccitas = $citas->count('doctor_id')
                    ->where([['doctor_id',$params[2]], ['estado','Pendiente']])
                    ->get();
    echo $ccitas;
}


    // public function getComments( $params=null ){
    //     $comments = new comments();
    //     $pid = $params[2];
    //     echo $comments -> getComments( $pid );
    // }

}