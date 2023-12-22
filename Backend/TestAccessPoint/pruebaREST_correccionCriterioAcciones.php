<?php

    class correccionCriterioAcciones{
        function insertar(){
            include_once './Testing/GestionCorreccionCriterio/Acciones/pruebaREST_CorreccionCriterio_Insertar_Acciones.php';
            $rest = pruebaREST_CorreccionCriterio_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCorreccionCriterio/Acciones/pruebaREST_CorreccionCriterio_Buscar_Acciones.php';
            $rest = pruebaREST_CorreccionCriterio_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCorreccionCriterio/Acciones/pruebaREST_CorreccionCriterio_Editar_Acciones.php';
            $rest = pruebaREST_CorreccionCriterio_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function assignRandom(){
            include_once './Testing/GestionCorreccionCriterio/Acciones/pruebaREST_CorreccionCriterio_AsignarAleatorio_Acciones.php';
            $rest = pruebaREST_CorreccionCriterio_AsignarAleatorio_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editarDocente(){
            include_once './Testing/GestionCorreccionCriterio/Acciones/pruebaREST_CorreccionCriterio_EditarDocente_Acciones.php';
            $rest = pruebaREST_CorreccionCriterio_EditarDocente_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>