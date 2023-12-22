<?php

class materiasAtributos {
    function insertar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_Insertar_Atributos.php';
        $rest = pruebaREST_Materias_Insertar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])){
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_ATRIBUTOS_EXITO';
        }
        else{
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_Buscar_Atributos.php';
        $rest = pruebaREST_Materias_Buscar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])){
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_ATRIBUTOS_EXITO';
        }
        else{
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function borrar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_Borrar_Atributos.php';
        $rest = pruebaREST_Materias_Borrar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])){
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BORRAR_ATRIBUTOS_EXITO';
        }
        else{
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BORRAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function editar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_Modificar_Atributos.php';
        $rest = pruebaREST_Materias_Modificar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_MODIFICAR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_MODIFICAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function solicitarImpartir() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_SolicitarImpartir_Atributos.php';
        $rest = pruebaREST_Materias_SolicitarImpartir_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function eliminarSolicitarImpartir() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_EliminarSolicitarImpartir_Atributos.php';
        $rest = pruebaREST_Materias_EliminarSolicitarImpartir_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscarSolicitarImpartir() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_BuscarSolicitarImpartir_Atributos.php';
        $rest = pruebaREST_Materias_BuscarSolicitarImpartir_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function insertarSolicitarCursar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_InsertarSolicitarCursar_Atributos.php';
        $rest = pruebaREST_Materias_InsertarSolicitarCursar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

     function buscarSolicitarCursar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_BuscarSolicitarCursar_Atributos.php';
        $rest = pruebaREST_Materias_BuscarSolicitarCursar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

     function eliminarSolicitarCursar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_EliminarSolicitarCursar_Atributos.php';
        $rest = pruebaREST_Materias_EliminarSolicitarCursar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

     function editarSolicitarCursar() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_EditarSolicitarCursar_Atributos.php';
        $rest = pruebaREST_Materias_EditarSolicitarCursar_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function aceptarSolicitarImpartir() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_AceptarSolicitarImpartir_Atributos.php';
        $rest = pruebaREST_Materias_AceptarSolicitarImpartir_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

     function aceptarSolicitarImpartirSecundario() {
        include_once './Testing/Materias/Atributos/pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Atributos.php';
        $rest = pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Atributos();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ATRIBUTOS_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ATRIBUTOS_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }
}
?>