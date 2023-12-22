<?php

include_once './Model/ModelBase.php';

class deliveryModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'entrega';
      $this->id = array('id_entrega');
      $this->foraneas = array('trabajo' => 'id_trabajo', 'usuario' => 'dni');
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>