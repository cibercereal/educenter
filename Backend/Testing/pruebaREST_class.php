<?php

class testRest{

	var $cliente;
	var $resultadoTest;
	var $token; //El token de las cabeceras
	var $tokenTEST;

	public function __construct(){

		// inicializar
		$this->cliente = $this->conectarCurl();
		$this->resultadoTest = array();
		$this->token = array();
		include_once './Core/config.php';

	}

	function conectarCurl(){

		$cliente = curl_init();
		return $cliente;
		
	}

	function desconectarCurl($cliente){

		curl_close($cliente);
		
	}

	function peticionCurl($cliente, $parametros){
		curl_setopt($cliente, CURLOPT_URL, urlRest);
		curl_setopt($cliente, CURLOPT_HEADER, 0);
		curl_setopt($cliente, CURLOPT_HTTPHEADER, $this->token); //meter la cabecera Authorization
		curl_setopt($cliente, CURLOPT_POST, True);
		curl_setopt($cliente, CURLOPT_POSTFIELDS, $parametros);
		curl_setopt($cliente, CURLOPT_RETURNTRANSFER, True); 
		
		$result = curl_exec($cliente); // obtengo un json
		//var_dump($result);exit;
		if (curl_error($cliente)) {
			echo 'Error: '.curl_e($cliente); 
		}
		else{
			$resp = json_decode($result); // convierto en un stdClass
			$resp = (array)$resp; //convierto en array
			return $resp;
		}	
	}

	function hacerPrueba($POST, $entidad, $accion, $tipo, $prueba, $codeEsperado){
		$POST['test'] = 'conectardbTest';
		//var_dump($POST);exit;
		if($accion == 'login'){
			$resp = $this->peticionCurl($this->cliente, $POST);
			if(isset($resp['resource'])){
				$this->token[0] = 'Authorization: '.$resp['resource'];
				$this->tokenTEST = $this->token[0];
			}
		}else{
			$this->token[0] = $this->tokenTEST;
			$resp = $this->peticionCurl($this->cliente, $POST);
		}

		if (!empty($resp) && $codeEsperado === $resp['code']) { $exito = 'TEST_EXITO'; } else { $exito = 'TEST_FRACASO'; }
		
		$datosPost = array();
		foreach ($POST as $key => $value) {
			if($key != 'test'){
				$datosPost[$key] = $value;
			}
		}

		$resultadoTestIndividual = array(
			'entidad' => $entidad,
			'accion' => $accion,
			'tipo' => $tipo,
			'prueba' => $prueba,
			'datos' => $datosPost,
			'RespEsperada' => $codeEsperado,
			'RespObtenida' => (!empty($resp) ? $resp['code'] : null),
			'exito' => $exito
		);

		if($resultadoTestIndividual['RespEsperada'] == $resultadoTestIndividual['RespObtenida']){
			$resultadoTestIndividual['code'] = 'PETICION_TEST_EXITO';
		}
		else{
			$resultadoTestIndividual['code'] = 'PETICION_TEST_FRACASO';
		}

		array_push($this->resultadoTest, $resultadoTestIndividual);
	}

	/**
	 * Permite realizar una petición sobre la BD de test y no devolvemos la respuesta.
	 */
	function peticionCurlNoTest($POST){
		$POST['test'] = 'conectardbTest';
		$this->token[0] = $this->tokenTEST;
		$resp = $this->peticionCurl($this->cliente, $POST);
		if(isset($resp['authorization'])){
			$this->token[0] = 'Authorization: '.$resp['authorization'];
			$this->tokenTEST = $this->token[0];
		}
	}

	/**
	 * Permite obtener una respuesta sobre una acción de la BD de test.
	 */
	function peticionCurlNoTestRespuesta($POST){
		$POST['test'] = 'conectardbTest';
		$this->token[0] = $this->tokenTEST;
		$resp = $this->peticionCurl($this->cliente, $POST);
        if(isset($resp['authorization'])){
            $this->token[0] = 'Authorization: '.$resp['authorization'];
            $this->tokenTEST = $this->token[0];
        }
		return $resp;
	}	

	/**
	 * Hacer una petición de lógin y obtener un token de autenticación válido
	 */
	function peticionLogin($POST){
		$POST['test'] = 'conectardbTest';
		$resp = $this->peticionCurl($this->cliente, $POST);
		if(isset($resp['resource'])){
			$this->token[0] = 'Authorization: '.$resp['resource'];
			$this->tokenTEST = $this->token[0];
		}
	}	


	function devolverTestRealizado(){
		return $this->resultadoTest;
	}

}
?>