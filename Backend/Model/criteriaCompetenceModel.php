<?php

include_once './Model/ModelBase.php';

class criteriaCompetenceModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'criterio_competencia';
      $this->id = array('id_criterio', 'id_competencia');
      $this->foraneas = array('criterio' => 'id_criterio', 'competencia' => 'id_competencia');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>