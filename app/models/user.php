<?php

    namespace app\models;

    class user extends Model {

        protected $table;
        protected $fillable = [
            'name',
            'username',
            'email',
            'passwd',
            'tipo',
            'activo',
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

    }