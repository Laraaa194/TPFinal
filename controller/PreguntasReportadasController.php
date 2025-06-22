<?php

class PreguntasReportadasController
{
    private $view;
    private $model;
    private $historialModel;

    public function __construct($view, $model,$historialModel)
    {
        $this->view = $view;
        $this->model = $model;
        $this->historialModel = $historialModel;
    }

    public function show(){

        $preguntasReportadas = $this->model->getPreguntasReportadas();

        $data = [
            'pagina' => 'preguntasReportadas',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
            'title' => 'Preguntas reportadas',
            'preguntas' => $preguntasReportadas
        ];

        $this->view->render("PreguntasReportadasEditor",$data);
    }

    public function buscar(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = trim($_POST['busqueda'] ?? '');

            $preguntas = $this->model->getPreguntasBuscadasReportadas($busqueda);

            $data= [
                'pagina' => 'preguntasReportadas',
                'mostrarLogo'=> true,
                'rutaLogo'=> '/LobbyEditor/show',
                'title' => 'Preguntas reportadas',
                'preguntas' => $preguntas

            ];

            $this->view->render("PreguntasReportadasEditor", $data);

        }
    }

    public function mostrarRevision($id_pregunta){


            $pregunta = $this->model->getPreguntaReportadaPorId($id_pregunta);
            $nombreCategoria = $this->model->getNombreCategoria($pregunta['id_categoria']);
            $respuestas = $this->model->getRespuestasReportadas($id_pregunta);

            $motivo = $this->model->getMotivoReportada($id_pregunta);

            $data = [
                'pagina' => 'revisionPreguntaReportada',
                'mostrarLogo'=> true,
                'title' => 'Revisión de pregunta',
                'rutaLogo'=> '/PreguntasReportadas/show',
                'pregunta' => $pregunta,
                'nombreCategoria' => $nombreCategoria,
                'respuestas' => $respuestas,
                'motivo' => $motivo['descripcion']
            ];

            $this->view->render("RevisionPreguntaReportada", $data);


   }

   public function eliminar($id_pregunta){
       $preguntaData = $this->model->getPreguntaReportadaPorId($id_pregunta);
       $enunciado = $preguntaData ? $preguntaData['enunciado'] : "Pregunta Desconocida";

       $this->model->eliminarPreguntaReportada($id_pregunta);

       $idEditorActual = $_SESSION['usuario']['id'];
       $tipoAccion = 'Eliminar Reporte';
       $detalle = "Se eliminó la pregunta reportada: \"{$enunciado}\".";
        $this->historialModel->registrarAccion($idEditorActual, $tipoAccion, $detalle);

        RedirectHelper::redirectTo('PreguntasReportadas/show');
   }

   public function borrarReporte($id_pregunta){
       $preguntaData = $this->model->getPreguntaReportadaPorId($id_pregunta);
       $enunciado = $preguntaData ? $preguntaData['enunciado'] : "Pregunta Desconocida";

       $this->model->borrarReporte($id_pregunta);

       $idEditorActual = $_SESSION['usuario']['id'];
       $tipoAccion = 'Denegar reporte';
       $detalle = "Se denegó el reporte de la pregunta: \"{$enunciado}\".";
       $this->historialModel->registrarAccion($idEditorActual, $tipoAccion, $detalle);

        RedirectHelper::redirectTo('PreguntasReportadas/show');
   }


}