<?php

include_once './Model/ModelBase.php';

class actionModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'accion';
      $this->id = array('id_accion');
      $this->foraneas = array();
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>