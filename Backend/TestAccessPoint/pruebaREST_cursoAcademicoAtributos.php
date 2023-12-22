<?php

    class cursoAcademicoAtributos {
        function insertar() {
            include_once './Testing/GestionCursoAcademico/Atributos/pruebaREST_CursoAcademico_Insertar_Atributos.php';
            $rest = pruebaREST_CursoAcademico_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCursoAcademico/Atributos/pruebaREST_CursoAcademico_Borrar_Atributos.php';
            $rest = pruebaREST_CursoAcademico_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCursoAcademico/Atributos/pruebaREST_CursoAcademico_Buscar_Atributos.php';
            $rest = pruebaREST_CursoAcademico_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCursoAcademico/Atributos/pruebaREST_CursoAcademico_Editar_Atributos.php';
            $rest = pruebaREST_CursoAcademico_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CURSO_ACADEMICO_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>