<?php

    class cursoAcademicoAcciones {
        function insertar(){
            include_once './Testing/GestionCursoAcademico/Acciones/pruebaREST_CursoAcademico_Insertar_Acciones.php';
            $rest = pruebaREST_CursoAcademico_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCursoAcademico/Acciones/pruebaREST_CursoAcademico_Buscar_Acciones.php';
            $rest = pruebaREST_CursoAcademico_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCursoAcademico/Acciones/pruebaREST_CursoAcademico_Eliminar_Acciones.php';
            $rest = pruebaREST_CursoAcademico_Eliminar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCursoAcademico/Acciones/pruebaREST_CursoAcademico_Editar_Acciones.php';
            $rest = pruebaREST_CursoAcademico_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

    }
    
?>