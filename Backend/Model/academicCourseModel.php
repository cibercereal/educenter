<?php

include_once './Model/ModelBase.php';

class academicCourseModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'curso_academico';
      $this->id = array('id_curso_academico');
      $this->foraneas = array();
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>