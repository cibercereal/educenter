<?php

include_once './Model/ModelBase.php';

class functionalityModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'funcionalidad';
      $this->id = array('id_funcionalidad');
      $this->foraneas = array();
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>