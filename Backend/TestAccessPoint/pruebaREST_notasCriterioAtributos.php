<?php

    class notasCriterioAtributos{

        function anadir(){
            include_once './Testing/GestionNotasCriterio/Atributos/pruebaREST_NotasCriterio_Anadir_Atributos.php';
            $rest = pruebaREST_NotasCriterio_Anadir_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_ANADIR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_ANADIR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionNotasCriterio/Atributos/pruebaREST_NotasCriterio_Buscar_Atributos.php';
            $rest = pruebaREST_NotasCriterio_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionNotasCriterio/Atributos/pruebaREST_NotasCriterio_Editar_Atributos.php';
            $rest = pruebaREST_NotasCriterio_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_NOTASCRITERIO_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>