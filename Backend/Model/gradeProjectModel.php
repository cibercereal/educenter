<?php

include_once './Model/ModelBase.php';

class gradeProjectModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'nota_trabajo';
      $this->id = array('id_trabajo', 'id_entrega');
      $this->foraneas = array('usuario' => 'dni', 'trabajo' => 'id_trabajo', 'entrega' => 'id_entrega');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>