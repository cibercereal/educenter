<?php

include_once './Model/ModelBase.php';

class actionFunctionalityModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'accion_funcionalidad';
      $this->id = array('id_accion', 'id_funcionalidad');
      $this->foraneas = array('accion' => 'id_accion', 'funcionalidad' => 'id_funcionalidad');
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>