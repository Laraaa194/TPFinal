<?php

class GestionPreguntasController
{
    private $view;
    private $model;

    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
    }
    public function show(){

        $preguntas = $this->model->getAllPreguntas();
        $cantidad_resultados = count($preguntas);

        $data = [
            'pagina' => 'gestionPreguntas',
            'mostrarLogo'=> true,
            'rutaLogo'=> '/LobbyEditor/show',
            'title' => 'Gestión de preguntas',
            'preguntas' => $preguntas,
            'cantidad_total' => $cantidad_resultados,
            'mostrarCantidad' => true

        ];

        $this->view->render("GestionPreguntasEditor",$data);
    }

    public function buscar(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = trim($_POST['busqueda'] ?? '');

            if ($busqueda === '') {
                $preguntas = $this->model->getAllPreguntas();
                $mensajeCantidad = "Hay " . count($preguntas) . " preguntas cargadas en total.";
            } else {
                $preguntas = $this->model->getAllPreguntasBuscadas($busqueda);
                $mensajeCantidad = "Se encontraron " . count($preguntas) . " resultados para tu búsqueda \"$busqueda\".";
            }

            $data= [
                'pagina' => 'gestionPreguntas',
                'mostrarLogo'=> true,
                'rutaLogo'=> '/LobbyEditor/show',
                'title' => 'Gestión de preguntas',
                'preguntas' => $preguntas,
                'mensajeCantidad' => $mensajeCantidad
            ];

            $this->view->render("GestionPreguntasEditor", $data);
        }
    }

    public function mostrarEdicion($id){

        $preguntaYRespuestas = $this->model->getPreguntaYRespuestas($id);
        $nombreCategoria = $this->model->getNombreCategoria($preguntaYRespuestas['pregunta']['id_categoria']);

        $data=
            [
                'pagina' => 'gestionPreguntas',
                'mostrarLogo'=> true,
                'title' => 'Editar pregunta',
                'rutaLogo'=> '/GestionPreguntas/show',
                'pregunta' => $preguntaYRespuestas['pregunta'],
                'respuestas' => $preguntaYRespuestas['respuestas'],
                'nombreCategoria' => $nombreCategoria
            ];

        $this->view->render("EdicionPregunta", $data);
    }

    public function eliminar(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['idPregunta'] ?? null;

            if ($id !== null) {
                $this->model->eliminarPregunta($id);
            }

            RedirectHelper::redirectTo('GestionPreguntas/show');
        }

    }

    public function guardarCambios(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $idPregunta = $_POST['idPregunta'];
            $categoria = (int)$_POST['selectCategoria'];
            $enunciadoPregunta = $_POST['enunciadoPregunta'] ?? '';
            $respuestas = $_POST['respuestas'];
            $respuestaCorrecta = $_POST['respuestaCorrecta'];

            $this->model->guardarCambios($idPregunta, $categoria, $enunciadoPregunta, $respuestas, $respuestaCorrecta);


            RedirectHelper::redirectTo('GestionPreguntas/show');
        }

    }

    public function showCrearPregunta()
    {
        $data=[
            'pagina' => 'gestionPreguntas',
            'rutaLogo' => '/GestionPreguntas/show',
            'mostrarLogo' => true,
            'title' => 'Crear pregunta',
            'rutaAction' => '/GestionPreguntas/agregarPregunta',
            'mostrarP' => false
        ];

        if (isset($_SESSION['errors'])) {
            $data['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }


        $this->view->render("CrearPregunta", $data);
    }

    public function agregarPregunta(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pregunta = $_POST['pregunta'] ?? '';
            $enunciadoPregunta = $_POST['pregunta'];
            $categoria = (int)$_POST['selectCategoria'];
            $respuestas = $_POST['respuesta'] ?? '';
            $respuestaCorrecta = $_POST['respuestaCorrecta'] ?? '';

            if ($this->model->getPreguntasPorEnunciado($enunciadoPregunta)) {
                $_SESSION['errors']['pregunta'] = 'Ya existe esa pregunta.';
            }
            if($enunciadoPregunta == null){
                $_SESSION['errors']['pregunta'] = 'Tenés que escribir una pregunta.';
            }
            if ($categoria == null) {
                $_SESSION['errors']['categoria'] = 'Tenés que seleccionar una categoría.';
            }
            foreach ($respuestas as $respuestaTexto) {
                if (trim($respuestaTexto) === '') {
                    $_SESSION['errors']['respuesta'] = 'Tenés que completar todas las respuestas.';
                    break;
                }
            }
            if ($respuestaCorrecta == null) {
                $_SESSION['errors']['respuestaCorrecta'] = 'Tenés que seleccionar cual es la correcta.';
            }
            if (!empty($_SESSION['errors'])) {
                RedirectHelper::redirectTo("GestionPreguntas/showCrearPregunta");
            }

            $this->model->editorAgregarPreguntaYRespuestas($enunciadoPregunta, $categoria, $respuestas, $respuestaCorrecta);
            RedirectHelper::redirectTo('GestionPreguntas/show');

        }
    }


}