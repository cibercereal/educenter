<?php

class rolAccionFuncionalidadAcciones {
    function insertar() {
        include_once './Testing/RolAccionFuncionalidad/Acciones/pruebaREST_RolAccionFuncionalidad_Insertar_Acciones.php';
        $rest = pruebaREST_RolAccionFuncionalidad_Insertar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function buscar() {
        include_once './Testing/RolAccionFuncionalidad/Acciones/pruebaREST_RolAccionFuncionalidad_Buscar_Acciones.php';
        $rest = pruebaREST_RolAccionFuncionalidad_Buscar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }

    function eliminar() {
        include_once './Testing/RolAccionFuncionalidad/Acciones/pruebaREST_RolAccionFuncionalidad_Eliminar_Acciones.php';
        $rest = pruebaREST_RolAccionFuncionalidad_Eliminar_Acciones();
        $respuesta['datos'] = $rest;
        if(calcularCodeExito($respuesta['datos'])) {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_EXITO';
        }
        else {
            $respuesta['code'] = 'PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_FRACASO';
        }
        devolverRespuestaTest($respuesta);
    }
}
?>