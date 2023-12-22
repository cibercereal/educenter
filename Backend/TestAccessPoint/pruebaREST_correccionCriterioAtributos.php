<?php

    class correccionCriterioAtributos{
        function insertar(){
            include_once './Testing/GestionCorreccionCriterio/Atributos/pruebaREST_CorreccionCriterio_Insertar_Atributos.php';
            $rest = pruebaREST_CorreccionCriterio_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCorreccionCriterio/Atributos/pruebaREST_CorreccionCriterio_Buscar_Atributos.php';
            $rest = pruebaREST_CorreccionCriterio_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function edit(){
            include_once './Testing/GestionCorreccionCriterio/Atributos/pruebaREST_CorreccionCriterio_Editar_Atributos.php';
            $rest = pruebaREST_CorreccionCriterio_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function assignRandom(){
            include_once './Testing/GestionCorreccionCriterio/Atributos/pruebaREST_CorreccionCriterio_AsignarAleatorio_Atributos.php';
            $rest = pruebaREST_CorreccionCriterio_AsignarAleatorio_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editarDocente(){
            include_once './Testing/GestionCorreccionCriterio/Atributos/pruebaREST_CorreccionCriterio_EditarDocente_Atributos.php';
            $rest = pruebaREST_CorreccionCriterio_EditarDocente_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>