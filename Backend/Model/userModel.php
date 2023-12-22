<?php

include_once './Model/ModelBase.php';

class userModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'usuario';
      $this->id = array('dni');
      $this->foraneas = array('rol' => 'id_rol');
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>