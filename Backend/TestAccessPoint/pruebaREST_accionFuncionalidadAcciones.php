<?php

class accionFuncionalidadAcciones {
    function insertar() {
        include_once './Testing/AccionFuncionalidad/Acciones/pruebaREST_AccionFuncionalidad_Insertar_Acciones.php';
        $rest = pruebaREST_AccionFuncionalidad_Insertar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscar() {
        include_once './Testing/AccionFuncionalidad/Acciones/pruebaREST_AccionFuncionalidad_Buscar_Acciones.php';
        $rest = pruebaREST_AccionFuncionalidad_Buscar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function eliminar() {
        include_once './Testing/AccionFuncionalidad/Acciones/pruebaREST_AccionFuncionalidad_Eliminar_Acciones.php';
        $rest = pruebaREST_AccionFuncionalidad_Eliminar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }
}
?>