<?php

include_once './Model/ModelBase.php';

class rolActionFunctionalityModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'rol_accion_funcionalidad';
      $this->id = array('id_rol', 'id_accion', 'id_funcionalidad');
      $this->foraneas = array('rol' => 'id_rol', 'accion' => 'id_accion', 'funcionalidad' => 'id_funcionalidad');
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>