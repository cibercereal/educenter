<?php

include_once './Core/config.php';

abstract class MappingBase{

	private static $db_host = host;
	private static $db_user = user;
	private static $db_pass = pass;
	private static $bd = BD;
	private static $bdTest = BDTEST;
	private static $directorioLog = directorioLog;
	private static $log_name = log_name;
	private static $db_name = BD;
	protected $query;
	protected $rows = array();
	private $conn;
	protected $stmt;
	protected $datos = array();
	public $ok = true;
	public $code = 'CONEXION_BD_OK';
	public $resource = '';
	public $feedback = array();
	public $erroresdatos = [];
	public $attributeListBD = array();
	public $mapping;

	function connection(){
		if (isset($_POST['test']) && $_POST['test'] == 'conectardbTest'){
			try{
				$this->conn = new PDO('mysql:host='.self::$db_host.';dbname='.self::$bdTest,self::$db_user,self::$db_pass);
			}catch(Exception $e){
				die('Error: '.$e->GetMessage());
			}finally{
				return $this->conn;
			}
		} else {
			try{
				$this->conn = new PDO('mysql:host='.self::$db_host.';dbname='.self::$bd,self::$db_user,self::$db_pass);
			}catch(Exception $e){
				die('Error: '.$e->GetMessage());
			}finally{
				return $this->conn;
			}
		}
	}

	// Simple query -> type: INSERT, DELETE, UPDATE
	protected function executeSingleQuery($values) {
        try {
            if (!($this->connection())) {
                fillExceptionAction('CONEXION_BD_KO');
            } else {
                if (!($this->stmt->execute($values))) {
                    fillExceptionAction('SQL_KO');
                }
            }
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                // Código de error específico para restricciones de integridad (clave foránea)
                fillExceptionAction('INTEGRITY_CONSTRAINT_VIOLATION_EXCEPTION');
            } else {
                // Otros errores PDO
                fillExceptionAction('SQL_KO');
            }
        }
	}

	// Results from query in array
	protected function getResultsFromQuery($values) {
		$this->resource = array();
		if (!($this->connection())){
			fillExceptionAction('CONEXION_BD_KO');
		}
		else{
			if(!empty($values)){
				if (!$this->stmt->execute($values)){
					fillExceptionAction('SQL_KO');
				}else{

					if ($this->stmt->rowCount() == 0){
						$this->ok = true;
						$this->code  = 'RECORDSET_VACIO'; // el recordset viene vacio
						$this->constructResponse();
					}
					else{
						$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
						$this->resource = $result;
						$this->ok = true;
						$this->code  = 'RECORDSET_DATOS'; // el recordset vuelve con datos
						$this->constructResponse();
					}
				}
			}
			else{
				if (!$this->stmt->execute()){
					fillExceptionAction('SQL_KO');
				}else{
	
					if ($this->stmt->rowCount() == 0){
						$this->ok = true;
						$this->code  = 'RECORDSET_VACIO'; // el recordset viene vacio
						$this->constructResponse();
					}
					else{
						$result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
						$this->resource = $result;
						$this->ok = true;
						$this->code  = 'RECORDSET_DATOS'; // el recordset vuelve con datos
						$this->constructResponse();
					}
				}
			}
			
		}
	}

	// Query by PK with result 
	protected function getOneResultFromQuery($values) {
		$this->resource = array();
		if (!($this->connection())){
			fillExceptionAction('CONEXION_BD_KO');
		}
		else{
			if(!empty($values)){
				if (!$this->stmt->execute($values)){
					fillExceptionAction('SQL_KO');
				}else{
					if ($this->stmt->rowCount() == 0){
						$this->ok = true;
						$this->code  = 'RECORDSET_VACIO'; // recordset empty
						$this->constructResponse();
					}else{
						$result = $this->stmt->fetch(PDO::FETCH_ASSOC);
						$this->resource = $result;
						$this->ok = true;
						$this->code  = 'RECORDSET_DATOS'; // recordset not empty
						$this->constructResponse();
					}
				}
			}
			else{
				if (!$this->stmt->execute()){
					fillExceptionAction('SQL_KO');
				}else{
					if ($this->stmt->rowCount() == 0){
						$this->ok = true;
						$this->code  = 'RECORDSET_VACIO'; // recordset empty
						$this->constructResponse();
					}else{
						$result = $this->stmt->fetch(PDO::FETCH_ASSOC);
						$this->resource = $result;
						$this->ok = true;
						$this->code  = 'RECORDSET_DATOS'; // recordset not empty
						$this->constructResponse();
					}
				}
			}
		}

	}

	protected function constructResponse() {
		$this->feedback['ok'] = $this->ok;
		$this->feedback['code'] = $this->code;
		$this->feedback['resource'] = $this->resource;
	}
}

?>