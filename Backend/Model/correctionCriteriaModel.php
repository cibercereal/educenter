<?php

include_once './Model/ModelBase.php';

class correctionCriteriaModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'correccion_criterio';
      $this->id = array('id_correccion_criterio');
      $this->foraneas = array();
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>