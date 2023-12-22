<?php

include_once './Model/ModelBase.php';

class criteriaModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'criterio';
      $this->id = array('id_criterio');
      $this->foraneas = array('trabajo' => 'id_trabajo');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>