<?php

    class competenciasAcciones{
        function insertar(){
            include_once './Testing/GestionCompetencias/Acciones/pruebaREST_Competencias_Insertar_Acciones.php';
            $rest = pruebaREST_Competencias_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCompetencias/Acciones/pruebaREST_Competencias_Buscar_Acciones.php';
            $rest = pruebaREST_Competencias_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCompetencias/Acciones/pruebaREST_Competencias_Borrar_Acciones.php';
            $rest = pruebaREST_Competencias_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCompetencias/Acciones/pruebaREST_Competencias_Editar_Acciones.php';
            $rest = pruebaREST_Competencias_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function asignar(){
            include_once './Testing/GestionCompetencias/Acciones/pruebaREST_Competencias_Asignar_Acciones.php';
            $rest = pruebaREST_Competencias_Asignar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_ASIGNAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_ASIGNAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
    
?>