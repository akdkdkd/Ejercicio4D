<?php

    namespace app\models;

    class pacientes extends Model {

        protected $table;
        protected $fillable = [
            'name',
            'nss',
            'contacto',
            'fenac',
            'genero',
            'email',
        ];

        public function __construct(){
            parent::__construct();
            $this->table = $this->connect();
        }

        public $values = [];
        // public function getComments( $pid ){
        //     $result = $this -> select([ 'a.id',
        //                                 'a.body',
        //                                 'date_format(a.created_at,"%d/%m/%Y") as fecha',
        //                                 'b.name'])
        //                     -> join('user b','a.userId=b.id')
        //                     -> where( [['a.active',1],['a.postId',$pid]])
        //                     -> get();
        //     return $result;
        // }        


public function getPacientes($params = null){
    // $doctor_id = $params[2] ?? null; // Obtener el doctor_id de los parámetros
    
    if (!$params) {
        return json_encode([]); // o lo que corresponda
    }

    $result = $this->select(['a.id', 'a.name', 'a.nss', 'a.contacto', 'a.fenac', 'a.genero', 'a.email'])
                   ->join('citas b', 'a.id=b.paciente_id')
                   ->where([['b.doctor_id', $params], ['b.estado', 'Pendiente']])
                   ->get();
    
    
    return $result;
}



    }