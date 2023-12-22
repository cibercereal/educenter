<?php

    class correccionDocenteAtributos{
        function buscar(){
            include_once './Testing/GestionCorreccionDocente/Atributos/pruebaREST_CorreccionDocente_Buscar_Atributos.php';
            $rest = pruebaREST_CorreccionDocente_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCorreccionDocente/Atributos/pruebaREST_CorreccionDocente_Editar_Atributos.php';
            $rest = pruebaREST_CorreccionDocente_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function eliminar(){
            include_once './Testing/GestionCorreccionDocente/Atributos/pruebaREST_CorreccionDocente_Eliminar_Atributos.php';
            $rest = pruebaREST_CorreccionDocente_Eliminar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function mostrarCorreccion(){
            include_once './Testing/GestionCorreccionDocente/Atributos/pruebaREST_CorreccionDocente_MostrarCorreccion_Atributos.php';
            $rest = pruebaREST_CorreccionDocente_MostrarCorreccion_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>