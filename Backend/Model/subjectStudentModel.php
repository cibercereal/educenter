<?php

include_once './Model/ModelBase.php';

class subjectStudentModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'materia_alumno';
      $this->id = array('id_materia', 'dni');
      $this->foraneas = array('usuario' => 'dni', 'materia' => 'id_materia');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>