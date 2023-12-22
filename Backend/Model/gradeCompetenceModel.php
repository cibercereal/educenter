<?php

include_once './Model/ModelBase.php';

class gradeCompetenceModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'nota_competencia';
      $this->id = array('id_trabajo', 'id_materia', 'id_competencia', 'dni', 'id_criterio');
      $this->foraneas = array('usuario' => 'dni', 'trabajo' => 'id_trabajo', 'materia' => 'id_materia', 'competencia' => 'id_competencia', 'criterio' => 'id_criterio');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>