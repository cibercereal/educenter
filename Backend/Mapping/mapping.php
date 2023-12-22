<?php

include_once './Mapping/MappingBase.php';

class mapping extends MappingBase {

    private $connection;
    private $dataQuery = array();
    private $valueQuery = array();
    
    public function __construct(){
		    $this->connection = $this->connection();
	  }

    /* 
     * Separa el array asociativo que contiene los datos y sus valuees en 
     * dos arrays para poder operar facilmente con PDO.
     */
    function dataValues($arrayDataValue){
        $this->dataQuery = array();
        $this->valueQuery = array();
        if(!empty($arrayDataValue)){
            foreach($arrayDataValue as $key => $value){
                array_push($this->dataQuery, $key);
                array_push($this->valueQuery, $value);
            }
        }
    }
  
////////////////////////////////////////////////////////ADD////////////////////////////////////////////////////////

    function lastInsertId($table, $id) {
        $this->query = "SELECT * FROM $table ORDER BY $id[0] DESC LIMIT 1";
        $this->stmt = $this->connection->query($this->query);
        $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
        $this->resource = $result;
        $this->ok = true;
        $this->code  = 'RECORDSET_DATOS'; // recordset not empty
        $this->constructResponse();
        return $this->feedback;
    }

    function ADD($table, $arrayDataValue){
        $this->dataValues($arrayDataValue);
        $y = '';
        foreach($this->valueQuery as $value){
            $y = $y.'?'.',';
        }
        $y = substr($y,0,-1);
        $data = $this->queryDataAdd($this->dataQuery);
       
        $this->query = "INSERT INTO $table ($data) values ($y)";
        $this->stmt = $this->connection->prepare($this->query);
        $this->executeSingleQuery($this->valueQuery);
    }

        /*
        * Creates the string data query to action INSERT.
        */
        private function queryDataAdd($dataQuery){
            $toret = '';
            foreach($dataQuery as $data){
                $toret = $toret.', '.$data;
            }
            return substr($toret, 2, strlen($toret));
        }

///////////////////////////////////////////////////////EDIT////////////////////////////////////////////////////////
    
function EDIT($table,$arrayDataValue,$condition,$conditionValues){
    $this->dataValues($arrayDataValue);

    $infoQuery = '';
    $infoWhere = '';

    $values = array();
        foreach($this->valueQuery as $value){
          array_push($values, $value);
        }
        foreach($conditionValues as $conditionValue){
          array_push($values, $conditionValue);
        }
        foreach($this->dataQuery as $value){
          $infoQuery = $infoQuery.$value.'=?, ';
        }
        foreach($condition as $valueCondition){
          $infoWhere = $infoWhere.$valueCondition.'=? AND ';
        }
        
        $infoQuery = substr($infoQuery,0,-2);
        $infoWhere = substr($infoWhere,0,-5);

      $this->query = "UPDATE $table SET $infoQuery WHERE $infoWhere";
      $this->stmt = $this->connection->prepare($this->query);
      $this->executeSingleQuery($values);
  }

  function DELETE($table, $arrayDataValue, $logic){
    $this->dataValues($arrayDataValue);
    $infoQuery = '';

    foreach($this->dataQuery as $value){
        $infoQuery = $infoQuery.'('.$value.' = ?) and ';
    }
    $infoQuery = substr($infoQuery,0,-5);

    if($logic) {
        $this->query = "UPDATE $table SET borrado_logico = 1 WHERE( $infoQuery )";
    } else {
        $this->query = "DELETE FROM $table WHERE( $infoQuery )";
    }
    $this->stmt = $this->connection->prepare($this->query);
    $this->executeSingleQuery($this->valueQuery);
  }

////////////////////////////////////////////Funciones de apoyo///////////////////////////////////////////////////////
      
    function getById($table,$dataQuery,$valueQuery){
        $this->query = "SELECT * FROM $table";
        if (!empty($dataQuery)){
            $infoWhere = $this->constructWhereSEARCH_BY($dataQuery);
            $this->query = "SELECT * FROM $table WHERE(($infoWhere))";
        }
        $this->stmt = $this->connection->prepare($this->query);
        $this->getOneResultFromQuery($valueQuery);
        return $this->feedback;
    }

    function seek_multiple($table,$dataQuery,$valueQuery){
        $this->query = "SELECT * FROM $table";
        if (!empty($dataQuery)){
            $infoQuery = $this->constructWhereSEARCH_BY($dataQuery);
            $this->query = "SELECT * FROM $table WHERE( $infoQuery )";
        }
        $this->stmt = $this->connection->prepare($this->query); 
        $this->getResultsFromQuery($valueQuery);
        return $this->feedback; 
    }

    function seek($table,$dataQuery,$valueQuery){
        $this->query = "SELECT * FROM $table";
        if (!empty($dataQuery)){
                $infoWhere = $this->constructWhereSEARCH_BY($dataQuery);
                $this->query = "SELECT * FROM $table WHERE($infoWhere)";
        }
        $this->stmt = $this->connection->prepare($this->query);
        $this->getOneResultFromQuery($valueQuery);
        return $this->feedback;
    }

    function constructWhereSEARCH_BY($dataQuery){
        $infoQuery = '';
            for($i = 0; $i < count($dataQuery); $i++){
                $infoQuery = $infoQuery.'('.$dataQuery[$i].' = ?) and ';
            }
            $infoQuery = substr($infoQuery,0,-5);

        return $infoQuery;
    }

    function max($table,$dataQuery){
        $this->query = "SELECT MAX($dataQuery) FROM $table";
        
        $this->stmt = $this->connection->prepare($this->query);
        $this->getOneResultFromQuery('');
        return $this->feedback;
    }

    function min($table,$dataQuery){
        $this->query = "SELECT MIN($dataQuery) FROM $table";
        
        $this->stmt = $this->connection->prepare($this->query);
        $this->getOneResultFromQuery('');
        return $this->feedback;
    }

    function SEARCH_GENERICO($table,$arrayDataValue, $foraneas, $start, $pageRaw, $orden, $tipoOrden, $id){
        $values = array();
        $this->query = "SELECT * FROM ".$table;
        $this->dataValues($arrayDataValue);  

        if (!empty($this->dataQuery)){
            $toret = $this->filterGenericWhere($arrayDataValue);
            $this->query = $this->query.' WHERE ('.$toret[0].')';
            $values = $toret[1];
        }
        
        if($orden != '' && $tipoOrden != ''){
            $this->query = $this->query.' ORDER BY ('.$orden.') '.$tipoOrden;
        }

        if (($start == 'nulo') && ($pageRaw == 'nulo')) {

            $this->stmt = $this->connection->prepare($this->query);
            $this->getResultsFromQuery($values);
        }

        else{
            $this->stmt = $this->connection->prepare($this->query);
            $this->getResultsFromQuery($values);

            if($start == 'nulo') { $start = 0;}

            if(count($this->feedback['resource']) == $start){
                $this->feedback['code'] = 'RECORDSET_VACIO';
                $this->feedback['resource'] = array();
            }
            else if(count($this->feedback['resource']) > $pageRaw){
                $this->feedback['resource'] = array_slice($this->feedback['resource'], $start, $pageRaw);
            }
        }

        $code = $this->feedback['code'];
        if (!empty($this->feedback['resource']) && !empty($foraneas)){
            foreach ($foraneas as $key => $value) {
                $this->feedback['resource'] = $this->includeForeigns($this->feedback['resource'], $key, $value, $id);
            }
        }
        $this->feedback['code'] = $code;

        return $this->feedback;
    }

    function includeForeigns($principal, $table, $key, $id){
        $foreignRaws = $this->searchForeigns($table);
        $auxiliar = array();
        
        if (empty($principal)){}
        else{
            foreach ($principal as $raw) {
                foreach ($foreignRaws['resource'] as $rawsForeign) {
                    if(strpos($id[0], $table) != false){
                        if ($raw[$key] == $rawsForeign[$id[0]]){
                            $raw[$key] = $rawsForeign;                               
                        }
                    }else{
                        if ($raw[$key] == $rawsForeign[$key]){
                            $raw[$key] = $rawsForeign;                               
                        }
                    }  
                }
            array_push($auxiliar, $raw);
          }
        }
        return $auxiliar;
    }

    function searchForeigns($table){
        $this->query = "SELECT * FROM ".$table;
        $this->stmt = $this->connection->prepare($this->query);
        $this->getResultsFromQuery(array());
        return $this->feedback;
    }

    function filterGenericWhere($arrayDataValue){
        $arrayDataValueLIKE = array();
        $arrayDataValueEQUAL = array();
        $valuesQuery = array();
        $query = '';

        foreach($arrayDataValue as $data => $value){
            $igual = substr($data,-6);
            if($igual == '_IGUAL'){
                $dataWithoutEqual = substr($data, 0, -6);
                $arrayDataValueEQUAL[$dataWithoutEqual] = $value;
            }
            else{
                $arrayDataValueLIKE[$data] = $value;
            }
        }

        if(!empty($arrayDataValueLIKE)){
            $query = $this->constructWhereSearchLike($arrayDataValueLIKE);
            $arrayValuesLike = $this->convertValuesLike(array_values($arrayDataValueLIKE));
            foreach($arrayValuesLike as $value){
                array_push($valuesQuery, $value);
            }
        }
        if(!empty($arrayDataValueEQUAL)){
            if($query != ''){
                $query = $query.' and '.$this->constructWhereSearch($arrayDataValueEQUAL);
            }else{
                $query = $this->constructWhereSearch($arrayDataValueEQUAL);
            }
            foreach($arrayDataValueEQUAL as $value){
                array_push($valuesQuery, $value);
            }
        }

        $toret[0] = $query;
        $toret[1] = $valuesQuery;
         return $toret;
        
      }

    function constructWhereSearchLike($dataValuesQuery){  
        $this->dataValues($dataValuesQuery);  
        $infoQuery = '';
        $valuesQuery = array_values($dataValuesQuery);
        for($i = 0; $i < count($this->dataQuery); $i++){
            $infoQuery = empty($valuesQuery[$i]) ? $infoQuery.'(lower('.$this->dataQuery[$i].') LIKE ? OR '.$this->dataQuery[$i].' IS NULL) and ' : $infoQuery.'(lower('.$this->dataQuery[$i].') LIKE ?) and ';
        }
        $infoQuery = substr($infoQuery,0,-5);
        return $infoQuery;
    }

    function convertValuesLike($valuesQuery){
        $toret = array();
        $values = (array)$valuesQuery;
        for($i = 0; $i < count($values); $i++){
          array_push($toret, '%'.strtolower($values[$i]).'%');
        } 
        return $toret;
    }

    function constructWhereSearch($dataValuesQuery){
        $this->dataValues($dataValuesQuery);
        $infoQuery = '';
            for($i = 0; $i < count($this->dataQuery); $i++){
                $infoQuery = $infoQuery.'('.$this->dataQuery[$i].' = ?) and ';
            }
            $infoQuery = substr($infoQuery,0,-5);
        return $infoQuery;
    }

    function countTuplas($table, $dataValuesQuery){
        $this->dataValues($dataValuesQuery);
        $values = array();
        $this->query = "SELECT COUNT(*) FROM ". $table;
  
        if (!empty($this->dataQuery)){
          $toret = $this->filterGenericWhere($dataValuesQuery);
          $this->query = $this->query.' WHERE ('.$toret[0].')';
          $values = $toret[1];
        }
  
        $this->stmt = $this->connection->prepare($this->query);
        $this->getResultsFromQuery($values);
        return $this->feedback;
      }

}
?>