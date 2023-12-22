<?php

include_once './Model/ModelBase.php';

class correctionTeacherModel extends ModelBase {

    public function __construct() {
      parent::__construct();
      $this->table = 'correccion_profesor';
      $this->id = array('id_correccion_profesor');
      $this->foraneas = array('criterio' => 'id_criterio', 'trabajo' => 'id_trabajo', 'entrega' => 'id_entrega', 'usuario' => 'dni');
      $this->orden = '';
      $this->tipoOrden = '';
    }
}
?>