<?php

include_once './Model/ModelBase.php';

class roleModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'rol';
      $this->id = array('id_rol');
      $this->foraneas = array();
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>