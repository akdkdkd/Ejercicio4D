<?php

namespace app\models;

class citas extends Model {

    protected $table;
    
    protected $fillable = [
        'id',
        'fecha',
        'hora',
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
    $result = $this->select(['a.id', 'a.fecha', 'a.hora', 'a.motivo', 'a.estado', 'b.name'])
        ->join('pacientes b', 'a.paciente_id=b.id')
        ->where([['a.doctor_id', $did], ['a.estado', 'Pendiente'], ['fecha', date('Y-m-d')]])
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

public function confirmarCita($id) {
    $sql = "UPDATE citas SET estado = 'Confirmada' WHERE id = ?";
    $stmt = $this->table->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
public function actualizarCita($data = []) {
    // print_r($data);
    $citaId = $data['id'] ?? null;
    $fechaCita = $data['fecha'] ?? null;
    $horaCita = $data['hora'] ?? null;
    $motivo = $data['motivo'] ?? null;

    $sql = "UPDATE citas SET fecha = ?, hora = ?, motivo = ? WHERE id = ?";
    $stmt = $this->table->prepare($sql);
    $stmt->bind_param("sssi", $fechaCita, $horaCita, $motivo, $citaId);
    $stmt->execute();
    $stmt->close();
    return $citaId; // Retorna el ID de la cita actualizada
}

//el campo se llama fecha (2025-05-13 11:30:00)
public function getHoras($dia){
    $result = $this->select(['fecha'])
        ->where([['fecha', 'LIKE', $dia . '%']])
        ->get();
}

public function createNewCita($data=[], $paciente_id = null) {
    $this->values = [];
    $this->values = [
        "",
        $data['fechaCita'],
        $data['horaCita'],
        $paciente_id, // Asumiendo que $paciente_id es el ID del paciente
        $data['doctor'],
        $data['motivo'],
        'Pendiente', // Estado por defecto
        // 'estado' => 'Pendiente',
    ];
    // print_r($this->values);
    return $this->create();
}

}
