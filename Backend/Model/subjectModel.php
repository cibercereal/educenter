<?php

include_once './Model/ModelBase.php';

class subjectModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'materia';
      $this->id = array('id_materia');
      $this->foraneas = array('usuario' => 'dni', 'curso_academico' => 'id_curso_academico');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>