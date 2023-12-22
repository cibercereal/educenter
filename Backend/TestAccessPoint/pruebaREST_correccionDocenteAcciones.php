<?php

    class correccionDocenteAcciones{
        function buscar(){
            include_once './Testing/GestionCorreccionDocente/Acciones/pruebaREST_CorreccionDocente_Buscar_Acciones.php';
            $rest = pruebaREST_CorreccionDocente_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCorreccionDocente/Acciones/pruebaREST_CorreccionDocente_Editar_Acciones.php';
            $rest = pruebaREST_CorreccionDocente_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function eliminar(){
            include_once './Testing/GestionCorreccionDocente/Acciones/pruebaREST_CorreccionDocente_Eliminar_Acciones.php';
            $rest = pruebaREST_CorreccionDocente_Eliminar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function mostrarCorreccion(){
            include_once './Testing/GestionCorreccionDocente/Acciones/pruebaREST_CorreccionDocente_MostrarCorreccion_Acciones.php';
            $rest = pruebaREST_CorreccionDocente_MostrarCorreccion_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>