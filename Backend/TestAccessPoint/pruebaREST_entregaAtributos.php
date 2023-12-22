<?php

    class entregaAtributos{
        function insertar(){
            include_once './Testing/GestionEntrega/Atributos/pruebaREST_Entrega_Insertar_Atributos.php';
            $rest = pruebaREST_Entrega_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionEntrega/Atributos/pruebaREST_Entrega_Borrar_Atributos.php';
            $rest = pruebaREST_Entrega_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionEntrega/Atributos/pruebaREST_Entrega_Buscar_Atributos.php';
            $rest = pruebaREST_Entrega_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionEntrega/Atributos/pruebaREST_Entrega_Editar_Atributos.php';
            $rest = pruebaREST_Entrega_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_ENTREGA_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>