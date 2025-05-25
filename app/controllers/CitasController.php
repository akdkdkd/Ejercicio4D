<?php

namespace app\controllers;

use app\models\posts as posts;
use app\models\comments as comments;
use app\models\citas as citas;
use app\models\interactions as inter;
use app\models\pacientes as pacientes;
use app\models\user as user;
use app\classes\View as View;
use app\controllers\auth\SessionController as SC;
// use app\models\pacientes

class CitasController extends Controller {
    public function __construct(){
        parent::__construct();
    }




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
    $pacientes = new citas();
    $pac = $pacientes->count('paciente_id')
                    // ->where([['estado','Pendiente']])
                    ->get();
    $user =new user();
    $tdoc = $user->count('username')
                    ->get();

    $activos = $user->count('activo')
                    ->where([['activo',1]])
                    ->get();



    echo json_encode(array_merge(json_decode($ccitas), json_decode($pac), json_decode($tdoc), json_decode($activos)));
}


public function getlista($params = null){
        //obtener pacientes
        $citas = new citas();
    $result = $citas->getCitas($params[2]);

    echo json_encode($result);
}

public function consultaCitas($params = null){
    $datos = filter_input_array(INPUT_POST , FILTER_SANITIZE_SPECIAL_CHARS);
    $pacientes = new pacientes();
    $result = $pacientes->where([["curp", $datos['curp']], ["email", $datos['email']]])->get();
    //imprimir el resultado en consola
    if(count(json_decode($result)) > 0){
        $citas = new citas();
        $result2 = $citas->where([["paciente_id", json_decode($result)[0]->id], ['estado', 'Pendiente']])->get();
        echo json_encode(["r" => json_decode($result2)]);

    }
}

public function cancelarCita(){

    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $citas = new citas();
    $citas->updateCita($id);



    echo json_encode($id);
}


// public function getPacientes($params = null){
//     $citas = new citas();
//     $pid = $params[2];
//     $citas = $citas->select(['a.id', 'b.name'])
//                     ->join('pacientes b', 'a.paciente_id = b.id')
//                     ->where([['a.doctor_id',$pid], ['a.estado','Pendiente']])
//                     ->get();
//     $pacientes = new citas();
//     $pac = $pacientes->count('paciente_id')
//                     ->where([['estado','Pendiente']])
//                     ->get();

// }

    // public function getComments( $params=null ){
    //     $comments = new comments();
    //     $pid = $params[2];
    //     echo $comments -> getComments( $pid );
    // }

}