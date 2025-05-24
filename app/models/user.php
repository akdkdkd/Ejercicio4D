<?php

    namespace app\models;

    class user extends Model {

        protected $table;
        protected $fillable = [
            'name',
            'username',
            'contacto',
            'fenac',
            'genero',
            'email',
            'especialidad',
            'activo',
            'passwd'
        ];

        public function __construct(){
            parent::__construct();
            $this->table = $this->connect();
        }

        public $values = [];

        public function newUser( $data = []){
            $this -> values = [
                $data['name'],
                $data['username'],
                $data['email'],
                sha1($data['passwd']),
                2,1
            ];
           return $this -> create();
        }

        public function getUser(){
            $result = $this -> count('id')
                            -> where([['activo',1]])
                            -> get();
            return $result;
        }

    }