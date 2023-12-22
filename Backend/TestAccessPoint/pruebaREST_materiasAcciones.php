<?php

class materiasAcciones {
    function insertar() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_Insertar_Acciones.php';
        $rest = pruebaREST_Materias_Insertar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscar() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_Buscar_Acciones.php';
        $rest = pruebaREST_Materias_Buscar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function borrar() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_Borrar_Acciones.php';
        $rest = pruebaREST_Materias_Borrar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BORRAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BORRAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function editar() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_Modificar_Acciones.php';
        $rest = pruebaREST_Materias_Modificar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_MODIFICAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_MODIFICAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function solicitarImpartir() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_SolicitarImpartir_Acciones.php';
        $rest = pruebaREST_Materias_SolicitarImpartir_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function eliminarSolicitarImpartir() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_EliminarSolicitarImpartir_Acciones.php';
        $rest = pruebaREST_Materias_EliminarSolicitarImpartir_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscarSolicitarImpartir() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_BuscarSolicitarImpartir_Acciones.php';
        $rest = pruebaREST_Materias_BuscarSolicitarImpartir_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function insertarSolicitarCursar() {
         include_once './Testing/Materias/Acciones/pruebaREST_Materias_InsertarSolicitarCursar_Acciones.php';
         $rest = pruebaREST_Materias_InsertarSolicitarCursar_Acciones();
         $respuesta['datos'] = $rest;
         if(calcularCodeExito($respuesta['datos'])) {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ACCIONES_EXITO';
         }
         else {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ACCIONES_FRACASO';
         }
         devolverRespuestaTest($respuesta);
    }

    function buscarSolicitarCursar() {
         include_once './Testing/Materias/Acciones/pruebaREST_Materias_BuscarSolicitarCursar_Acciones.php';
         $rest = pruebaREST_Materias_BuscarSolicitarCursar_Acciones();
         $respuesta['datos'] = $rest;
         if(calcularCodeExito($respuesta['datos'])) {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ACCIONES_EXITO';
         }
         else {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ACCIONES_FRACASO';
         }
         devolverRespuestaTest($respuesta);
    }

    function eliminarSolicitarCursar() {
         include_once './Testing/Materias/Acciones/pruebaREST_Materias_EliminarSolicitarCursar_Acciones.php';
         $rest = pruebaREST_Materias_EliminarSolicitarCursar_Acciones();
         $respuesta['datos'] = $rest;
         if(calcularCodeExito($respuesta['datos'])) {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ACCIONES_EXITO';
         }
         else {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ACCIONES_FRACASO';
         }
         devolverRespuestaTest($respuesta);
    }

    function editarSolicitarCursar() {
         include_once './Testing/Materias/Acciones/pruebaREST_Materias_EditarSolicitarCursar_Acciones.php';
         $rest = pruebaREST_Materias_EditarSolicitarCursar_Acciones();
         $respuesta['datos'] = $rest;
         if(calcularCodeExito($respuesta['datos'])) {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ACCIONES_EXITO';
         }
         else {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ACCIONES_FRACASO';
         }
         devolverRespuestaTest($respuesta);
    }

    function aceptarSolicitarImpartir() {
        include_once './Testing/Materias/Acciones/pruebaREST_Materias_AceptarSolicitarImpartir_Acciones.php';
        $rest = pruebaREST_Materias_AceptarSolicitarImpartir_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function aceptarSolicitarImpartirSecundario() {
         include_once './Testing/Materias/Acciones/pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Acciones.php';
         $rest = pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Acciones();
         $respuesta['datos'] = $rest;
         if(calcularCodeExito($respuesta['datos'])) {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ACCIONES_EXITO';
         }
         else {
             $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ACCIONES_FRACASO';
         }
         devolverRespuestaTest($respuesta);
    }
}
?>