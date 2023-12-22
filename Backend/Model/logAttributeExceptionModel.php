<?php

include_once './Model/ModelBase.php';

class logAttributeExceptionModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'logattributeexception';
      $this->id = array('usuario', 'tiempo');
      $this->foreign = array();
      $this->orden = 'tiempo';
      $this->tipoOrden = 'DESC';
    }

}
?>