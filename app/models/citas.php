<?php

namespace app\models;

class citas extends Model {

    protected $table;
    
    protected $fillable = [
        'fecha',
        'paciente_id',
        'doctor_id',
        'motivo',
        'estado',
    ];

    public function __construct() {
        parent::__construct();
        $this->table = $this->connect();
    }

    public $values = [];

public function getCitas($did) {
    $hoy = date('Y-m-d');

    $result = $this->select([
                        'a.id',
                        'a.fecha',
                        'a.motivo',
                        'a.estado',
                        'b.name as paciente',
                        'c.name as doctor'
                    ])
                    ->join('pacientes b', 'a.paciente_id = b.id')
                    ->join('user c', 'a.doctor_id = c.id')
                    ->whereLike([
                        ['a.estado', 'Pendiente'],
                        ['a.doctor_id', $did],
                        ['DATE(a.fecha)', $hoy] // <- Esto asegura la fecha del día
                    ])
                    ->get();

    return $result;
}

}
