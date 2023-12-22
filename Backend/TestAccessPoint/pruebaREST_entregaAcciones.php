<?php

    class entregaAcciones{
        function insertar(){
            include_once './Testing/GestionEntrega/Acciones/pruebaREST_Entrega_Insertar_Acciones.php';
            $rest = pruebaREST_Entrega_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionEntrega/Acciones/pruebaREST_Entrega_Buscar_Acciones.php';
            $rest = pruebaREST_Entrega_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionEntrega/Acciones/pruebaREST_Entrega_Borrar_Acciones.php';
            $rest = pruebaREST_Entrega_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionEntrega/Acciones/pruebaREST_Entrega_Editar_Acciones.php';
            $rest = pruebaREST_Entrega_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

    }
    
?>