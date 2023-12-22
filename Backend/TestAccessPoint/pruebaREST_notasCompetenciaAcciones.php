<?php

    class notasCompetenciaAcciones {

        function visualizar(){
            include_once './Testing/GestionNotasCompetencia/Acciones/pruebaREST_NotasCompetencia_Visualizar_Acciones.php';
            $rest = pruebaREST_NotasCompetencia_Visualizar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionNotasCompetencia/Acciones/pruebaREST_NotasCompetencia_Buscar_Acciones.php';
            $rest = pruebaREST_NotasCompetencia_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionNotasCompetencia/Acciones/pruebaREST_NotasCompetencia_Editar_Acciones.php';
            $rest = pruebaREST_NotasCompetencia_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>