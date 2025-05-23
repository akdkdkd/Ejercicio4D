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



    }