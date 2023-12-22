<?php

include_once './Mapping/mapping.php';

class ModelBase {
	
    protected $mapping;
	protected $table;
    protected $id;
	public $start;
	public $pageRaw;
	public $criteriosbusqueda;

	public function __construct() {
		$this->mapping = new mapping();	
	}

    function getLastId() {
       return $this->mapping->lastInsertId($this->table, $this->id);
    }

	function ADD() {
		$this->mapping->ADD($this->table, $this->arrayDataValue);
	}

	function EDIT(){
		$conditionValue = array();
		foreach ($this->arrayDataValue as $key => $value) { 
			foreach($this->id as $elementId){
				if($key == $elementId){
					array_push($conditionValue, $value);
				}
			}
		} 
		
		foreach ($this->id as $value) { 
			foreach($this->arrayDataValue as $dato => $valor){
				if($value == $dato){
					unset($this->arrayDataValue[$value]);
				}
			}
		}
		
		$this->mapping->EDIT($this->table, $this->arrayDataValue, $this->id, $conditionValue);
	}

	function LOGIC_DELETE() {
		$this->mapping->DELETE($this->table, $this->arrayDataValue, true);
	}
	
	function DELETE() {
		$this->mapping->DELETE($this->table, $this->arrayDataValue, false);
	}

	function getById($valuesQuery) {
		return $this->mapping->getById($this->table, $this->id, $valuesQuery);
	}

	function seek($datosQuery,$valuesQuery) {
		return $this->mapping->seek($this->table, $datosQuery, $valuesQuery);
	}

	function seek_multiple($datosQuery,$valuesQuery) {
        return $this->mapping->seek_multiple($this->table, $datosQuery, $valuesQuery);
    }

	function SEARCH() {
		$result = $this->mapping->SEARCH_GENERICO($this->table, $this->arrayDataValue, $this->foraneas, $this->start, $this->pageRaw, $this->orden, $this->tipoOrden, $this->id);
		$raws = $result['resource'];

		if($this->start == 'nulo') {$this->start = 0;}
		if (!empty($raws)) { 
			$rawsenrespuesta = count($raws);
		} else {
			$rawsenrespuesta = 0; 
		}
		
		$result1 = $this->mapping->countTuplas($this->table, $this->arrayDataValue);
		$total = $result1['resource'];
		$total = $total[0]['COUNT(*)'];

		$feedback=array('ok' => $result['ok'], 
						'code' => $result['code'],
						'resource'=>$raws,
						'total'=>$total,
						'empieza'=>$this->start, 
						'filas'=>$rawsenrespuesta, 
						'criteriosbusqueda' => $this->criteriosbusqueda);

		return $feedback;
	}

}
?>