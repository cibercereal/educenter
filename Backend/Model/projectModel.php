<?php

include_once './Model/ModelBase.php';

class projectModel extends ModelBase {

    public function __construct(){
      parent::__construct();
      $this->table = 'trabajo';
      $this->id = array('id_trabajo');
      $this->foraneas = array('materia' => 'id_materia');
      $this->orden = '';
      $this->tipoOrden = '';
    }

}
?>