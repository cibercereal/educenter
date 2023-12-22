<?php

    class notasCompetenciaAtributos{

        function visualizar(){
            include_once './Testing/GestionNotasCompetencia/Atributos/pruebaREST_NotasCompetencia_Visualizar_Atributos.php';
            $rest = pruebaREST_NotasCompetencia_Visualizar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionNotasCompetencia/Atributos/pruebaREST_NotasCompetencia_Buscar_Atributos.php';
            $rest = pruebaREST_NotasCompetencia_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionNotasCompetencia/Atributos/pruebaREST_NotasCompetencia_Editar_Atributos.php';
            $rest = pruebaREST_NotasCompetencia_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>