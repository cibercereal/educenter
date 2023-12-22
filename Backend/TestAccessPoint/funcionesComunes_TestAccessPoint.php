<?php

    function calcularCodeExito($test){
        $toret = true;
        foreach($test as $prueba){
            if($prueba['exito'] == 'TEST_FRACASO'){
                $toret = false;
            }
        }
        return $toret;
    }

    function devolverRespuestaTest($test){
        header('Content-type: application/json');
        echo(json_encode(array_reverse($test)));
		exit();
	}

?>