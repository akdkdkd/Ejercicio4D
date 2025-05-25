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
    $result = $this->select(['a.id', 'a.fecha', 'a.motivo', 'a.estado', 'b.name'])
        ->join('pacientes b', 'a.paciente_id=b.id')
        ->where([['a.doctor_id', $did], ['a.estado', 'Pendiente']])
        ->get();

    return $result;
}

public function eliminarCita($id) {
    $result = $this->where([['id', $id]])->delete();
    return $result;
}

public function updateCita($id){
    $sql = "UPDATE citas SET estado = 'Cancelada' WHERE id = ?";
    $stmt = $this->table->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

}
