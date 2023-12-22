<?php

include_once './Model/ModelBase.php';

class logExceptionActionsModel extends ModelBase{

    public function __construct(){
      parent::__construct();
      $this->table = 'logexcepcionaccion';
      $this->id = array('usuario', 'tiempo');
      $this->foreign = array();
      $this->orden = 'tiempo';
      $this->tipoOrden = 'DESC';
    }

}
?>