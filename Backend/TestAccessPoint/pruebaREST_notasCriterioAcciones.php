<?php

    class notasCriterioAcciones {

        function anadir(){
            include_once './Testing/GestionNotasCriterio/Acciones/pruebaREST_NotasCriterio_Anadir_Acciones.php';
            $rest = pruebaREST_NotasCriterio_Anadir_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_ANADIR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_ANADIR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionNotasCriterio/Acciones/pruebaREST_NotasCriterio_Buscar_Acciones.php';
            $rest = pruebaREST_NotasCriterio_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionNotasCriterio/Acciones/pruebaREST_NotasCriterio_Editar_Acciones.php';
            $rest = pruebaREST_NotasCriterio_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>