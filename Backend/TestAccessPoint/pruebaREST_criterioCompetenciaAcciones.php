<?php

    class criterioCompetenciaAcciones{
        function insertar(){
            include_once './Testing/GestionCriterioCompetencia/Acciones/pruebaREST_CriterioCompetencia_Insertar_Acciones.php';
            $rest = pruebaREST_CriterioCompetencia_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCriterioCompetencia/Acciones/pruebaREST_CriterioCompetencia_Buscar_Acciones.php';
            $rest = pruebaREST_CriterioCompetencia_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCriterioCompetencia/Acciones/pruebaREST_CriterioCompetencia_Borrar_Acciones.php';
            $rest = pruebaREST_CriterioCompetencia_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>