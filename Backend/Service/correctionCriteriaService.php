<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/correctionCriteriaValidation.php';

class correctionCriteriaService extends ServiceBase {

    private $userModel;
    private $projectModel;
    private $subjectModel;
    private $subjectTeacherModel;
    private $deliveryModel;
    private $subjectStudentModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('dni_alumno', 'id_trabajo', 'id_entrega', 'fecha_fin_correccion');
            break;
            case 'search':
                $this->attributeList = array('dni_alumno', 'id_entrega', 'id_trabajo', 'fecha_fin_correccion');
                $this->listAttributesEqual = array('dni_alumno', 'id_entrega', 'id_trabajo', 'fecha_fin_correccion');
            break;
            case 'assignRandom':
                $this->attributeList = array('numero_alumnos', 'id_trabajo', 'fecha_fin_correccion');
            break;
            case 'edit':
                $this->attributeList = array('id_correccion_criterio', 'correccion_alumno', 'comentario_alumno');
            break;
            case 'editTeacher':
                $this->attributeList = array('id_correccion_criterio', 'correccion_docente', 'comentario_docente');
            break;
            case 'delete':
                $this->attributeList = array('id_correccion_criterio');
            break;
        }

        $this->model = $this->createModelOne('correctionCriteria');
        $this->userModel = $this->createModelOne('user');
        $this->projectModel = $this->createModelOne('project');
        $this->subjectModel = $this->createModelOne('subject');
        $this->deliveryModel = $this->createModelOne('delivery');
        $this->subjectStudentModel = $this->createModelOne('subjectStudent');
        $this->subjectTeacherModel = $this->createModelOne('subjectAssignment');
        $this->validationClass = $this->createValidationOne('correctionCriteria');
        $this->validationClass->model = $this->model;
        $this->validationClass->user = $this->userModel;
        $this->validationClass->subject = $this->subjectModel;
        $this->validationClass->delivery = $this->deliveryModel;
        $this->validationClass->project = $this->projectModel;
        $this->validationClass->subjectTeacher = $this->subjectTeacherModel;
        $this->validationClass->subjectStudent = $this->subjectStudentModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $criterias = $this->createModelOne('criteria')->seek_multiple(array('id_trabajo'), array($this->model->arrayDataValue['id_trabajo']))['resource'];
                $correctionTeacher = $this->createModelOne('correctionTeacher');
                $correctionTeacher->arrayDataValue = [];
                $correctionTeacher->arrayDataValue['id_trabajo'] = $this->model->arrayDataValue['id_trabajo'];
                $correctionTeacher->arrayDataValue['id_entrega'] = $this->model->arrayDataValue['id_entrega'];
                foreach($criterias as $criteria) {
                    $correctionTeacher->arrayDataValue['id_criterio'] = $criteria['id_criterio'];
                    $this->model->arrayDataValue['id_criterio'] = $criteria['id_criterio'];
                    $this->validateAdd();
                    $exists = $correctionTeacher->seek(array('id_criterio', 'id_trabajo', 'id_entrega'), array($criteria['id_criterio'], $correctionTeacher->arrayDataValue['id_trabajo'], $correctionTeacher->arrayDataValue['id_entrega']));
                    if (empty($exists['resource'])) {
                        $correctionTeacher->ADD();
                    }
                    $this->model->ADD();
                }
                $this->addGradeProject();
                return $this->addCorrectionCriteria('ANADIR_CORRECCION_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_criterio'] = isset($this->model->arrayDataValue['id_criterio']) ? $this->model->arrayDataValue['id_criterio'] : '';
                $this->model->arrayDataValue['id_entrega'] = isset($this->model->arrayDataValue['id_entrega']) ? $this->model->arrayDataValue['id_entrega'] : '';
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['fecha_fin_correccion'] = isset($this->model->arrayDataValue['fecha_fin_correccion']) ? $this->model->arrayDataValue['fecha_fin_correccion'] : '';
                $this->validateSearch();
                return $this->search();
            break;
            case 'assignRandom':
                $numberStudents = $this->model->arrayDataValue['numero_alumnos'];
                $projectId = $this->model->arrayDataValue['id_trabajo'];
                unset($this->model->arrayDataValue['numero_alumnos']);
                // Obtener las entregas de los alumnos
                $deliveries = $this->deliveryModel->seek_multiple(array('id_trabajo'), array($projectId))['resource'];
                // Obtener la materia del trabajo
                $subject = $this->projectModel->getById(array($projectId))['resource']['id_materia'];
                // Obtener los alumnos que cursan la materia del id_trabajo
                $students = $this->createModelOne('subjectStudent')->seek_multiple(array('id_materia'), array($subject))['resource'];
                foreach ($deliveries as $delivery) {
                    $subjectStudents = $students;
                    $dni = $delivery['dni'];
                    $deliveryId = $delivery['id_entrega'];
                    $this->model->arrayDataValue['id_entrega'] = $deliveryId;
                    // Obtener los alumnos que ya tienen asignada corrección
                    $correctionStudent = $this->model->seek_multiple(array('id_entrega'), array($deliveryId))['resource'];
                    $n = sizeof($correctionStudent);
                    $dniCorrection = array();
                    foreach($correctionStudent as $correction) {
                        if (empty($dniCorrection) || !in_array($correction['dni_alumno'], $dniCorrection)) {
                            array_push($dniCorrection, $correction['dni_alumno']);
                        }
                    }

                    $flag = false;
                    while ($n < (int) $numberStudents) {
                        //Obtener los criterios necesarios a corregir
                        $criterias = $this->createModelOne('criteria')->seek_multiple(array('id_trabajo'), array($projectId))['resource'];
                        $ultimoElemento = array_pop($subjectStudents);
                        if (isset($ultimoElemento['dni']) && $ultimoElemento['dni'] != $dni && !in_array($ultimoElemento['dni'], $dniCorrection)) {
                            $correctionTeacher = $this->createModelOne('correctionTeacher');
                            $correctionTeacher->arrayDataValue = [];
                            $correctionTeacher->arrayDataValue['id_trabajo'] = $this->model->arrayDataValue['id_trabajo'];
                            $correctionTeacher->arrayDataValue['id_entrega'] = $this->model->arrayDataValue['id_entrega'];
                           foreach($criterias as $criteria) {
                                $correctionTeacher->arrayDataValue['id_criterio'] = $criteria['id_criterio'];
                                $this->model->arrayDataValue['id_criterio'] = $criteria['id_criterio'];
                                $this->model->arrayDataValue['dni_alumno'] = $ultimoElemento['dni'];
                                $this->validateAdd();
                                $exists = $correctionTeacher->seek(array('id_criterio', 'id_trabajo', 'id_entrega'), array($criteria['id_criterio'], $correctionTeacher->arrayDataValue['id_trabajo'], $correctionTeacher->arrayDataValue['id_entrega']));
                                if (empty($exists['resource'])) {
                                    $correctionTeacher->ADD();
                                }
                                $this->model->ADD();
                                $flag = true;
                           }
                        } else {
                            if (sizeof($subjectStudents) != 0) {
                                array_unshift($correctionStudent, $ultimoElemento);
                            }
                        }
                       $n++;
                    }
                    if ($flag) {$this->addGradeProject();}
                }
                return $this->addCorrectionCriteria('ANADIR_CORRECCION_OK');
            break;
            case 'edit':
                $this->validateEdit();
                return $this->editCorrectionCriteria('EDITAR_CORRECCION_CRITERIO_OK');
            break;
            case 'editTeacher':
                $this->validationClass->validateEditTeacher();
                return $this->editCorrectionCriteria('EDITAR_CORRECCION_CRITERIO_OK');
            break;
            case 'delete':
                $this->model->DELETE();
                return $this->createFeedback('ELIMINAR_CORRECCION_CRITERIO_OK');
            break;
        }
    }

    function addCorrectionCriteria($msg) {
        return $this->createFeedback($msg);
    }

    function editCorrectionCriteria($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }

    function addGradeProject() {
        $gradeProject = $this->createModelOne('gradeProject');
        $gradeProject->arrayDataValue = [];
        $gradeProject->arrayDataValue['id_trabajo'] = $this->model->arrayDataValue['id_trabajo'];
        $gradeProject->arrayDataValue['id_entrega'] = $this->model->arrayDataValue['id_entrega'];
        $gradeProject->ADD();
    }
}
?>