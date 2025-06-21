<?php

class PreguntasReportadasController
{
    private $view;
    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
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


            $data = [
                'pagina' => 'revisionPreguntaReportada',
                'mostrarLogo'=> true,
                'title' => 'Revisión de pregunta',
                'rutaLogo'=> '/PreguntasReportadas/show',
                'pregunta' => $pregunta,
                'nombreCategoria' => $nombreCategoria,
                'respuestas' => $respuestas
            ];

            $this->view->render("RevisionPreguntaReportada", $data);


   }

   public function eliminar($id_pregunta){
        $this->model->eliminarPreguntaReportada($id_pregunta);
        RedirectHelper::redirectTo('PreguntasReportadas/show');
   }

   public function borrarReporte($id_pregunta){
        $this->model->borrarReporte($id_pregunta);
        RedirectHelper::redirectTo('PreguntasReportadas/show');
   }


}