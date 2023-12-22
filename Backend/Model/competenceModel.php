<?php

include_once './Model/ModelBase.php';

class competenceModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'competencia';
      $this->id = array('id_competencia');
      $this->foraneas = array('materia' => 'id_materia');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>