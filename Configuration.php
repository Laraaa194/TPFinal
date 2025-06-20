<?php

require_once("helper/RedirectHelper.php");
require_once("helper/SessionHelper.php");

require_once("core/Database.php");
require_once("core/FilePresenter.php");
require_once("core/MustachePresenter.php");
require_once("core/Router.php");

require_once("controller/HomeController.php");
require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");
require_once ("controller/LobbyController.php");
require_once("controller/PerfilController.php");
require_once("controller/PartidaController.php");
require_once("controller/PreguntaController.php");
require_once("controller/ResultadoController.php");
require_once("controller/RankingController.php");
require_once("controller/CrearPreguntaController.php");
require_once ("controller/LobbyEditorController.php");
require_once ("controller/PreguntasSugeridasController.php");
require_once ("controller/PreguntasReportadasController.php");
require_once ("controller/GestionPreguntasController.php");


require_once("model/LoginModel.php");
require_once("model/RegisterModel.php");
require_once("model/PerfilModel.php");
require_once("model/PreguntaModel.php");
require_once("model/PartidaModel.php");
require_once ("model/PartidaPreguntaModel.php");
require_once ("model/PreguntaUsuarioModel.php");
require_once ("model/UsuarioModel.php");
require_once ("model/CrearPreguntaModel.php");
require_once ("model/PreguntasEditorModel.php");

include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    private $config;
    public function getDatabase()
    {
        $this->config = $this->getIniConfig();

        return new Database(
            $this->config["database"]["server"],
            $this->config["database"]["user"],
            $this->config["database"]["dbname"],
            $this->config["database"]["pass"]
        );
    }

    public function getIniConfig()
    {
        return parse_ini_file("configuration/config.ini", true);
    }

    public function getHomeController()
    {
        return new HomeController($this->getViewer());
    }

    public function getLoginController(){
        return new LoginController
        (new LoginModel($this->getDatabase()), $this->getViewer());
    }

    public function getPerfilController()
    {
        return new PerfilController
        (new PerfilModel($this->getDatabase()), $this->getViewer(), new PartidaModel($this->getDatabase()));
    }

    public function getRegisterController(){
        return new RegisterController
            (new RegisterModel($this->getDatabase()), $this->getViewer());
    }

    public function getLobbyController(){
        return new LobbyController
        ($this->getViewer(), new PartidaModel($this->getDatabase()));
    }

    public function getPartidaController(){
        return new PartidaController
            ($this->getViewer(),
            new PartidaModel($this->getDatabase()),
            new PreguntaModel($this->getDatabase(), new PreguntaUsuarioModel($this->getDatabase())),
            new PartidaPreguntaModel($this->getDatabase()));
    }

    public function getReportarPreguntaController(){
        $preguntaUsuarioModel = new PreguntaUsuarioModel( $this->getDatabase());
        return new ReportarPreguntaController(new PreguntaModel( $this->getDatabase(), $preguntaUsuarioModel),$this->getViewer());
    }

    public function getPreguntaController(){
        $preguntaUsuarioModel = new PreguntaUsuarioModel( $this->getDatabase());

        return new PreguntaController(
            new PreguntaModel( $this->getDatabase(), $preguntaUsuarioModel),
            $this->getViewer(),
            new PartidaPreguntaModel( $this->getDatabase()),
            $preguntaUsuarioModel,
            new UsuarioModel($this->getDatabase())
        );
    }

    public function getResultadoController()
    {

        return new ResultadoController(
            $this->getViewer());
    }
    public function getRankingController() {
        return new RankingController(
            $this->getViewer(), new PartidaModel($this->getDatabase())
        );
    }

    public function getLobbyEditorController(){
        return new LobbyEditorController(
            $this->getViewer());
    }

    public function getcrearPreguntaController(){
        return new crearPreguntaController(
            $this->getViewer(),
            new CrearPreguntaModel($this->getDatabase()));
    }

    public function getPreguntasSugeridasController(){
        return new PreguntasSugeridasController(
            $this->getViewer(),
            new PreguntasEditorModel($this->getDatabase()),
            new CrearPreguntaModel($this->getDatabase()));
    }

    public function getPreguntasReportadasController(){
        return new PreguntasReportadasController(
            $this->getViewer(),
            new PreguntasEditorModel($this->getDatabase())
        );
    }

    public function getGestionPreguntasController(){
        return new GestionPreguntasController(
            $this->getViewer(),
            new PreguntasEditorModel($this->getDatabase())
        );
    }

    public function getRouter()
    {
        return new Router("getHomeController", "show", $this);
    }

    public function getViewer()
    {
        //return new FileView();
        return new MustachePresenter("view");
    }

    public function validateSession($controller) {
        $controllersRequierenLogin = ['Perfil', 'Lobby', 'Partida', 'Pregunta', 'Resultado', 'Ranking', 'LobbyEditor', 'PreguntasReportadas', 'PreguntasSugeridas', 'CrearPregunta', 'GestionPreguntas'];

        if (in_array($controller, $controllersRequierenLogin)) {
            SessionHelper::requiereLogin();
        } elseif ($controller === 'Login' || $controller === 'Register') {
            SessionHelper::LoginStarter();
        }
    }


    public function validateRole($controller) {
        if (!isset($_SESSION['usuario']['id'])) {
            return;
        }

        $tipo = SessionHelper::getUserType(); // 1 = Jugador, 2 = Editor

        $roles = [
            1 => ['home', 'Register', 'Login', 'Perfil', 'Lobby', 'Partida', 'Pregunta', 'Resultado', 'Ranking', 'CrearPregunta'],
            2 => ['home', 'Login', 'LobbyEditor', 'PreguntasReportadas', 'PreguntasSugeridas', 'CrearPregunta', 'GestionPreguntas']
        ];

        // Si el controlador actual no está permitido para el tipo de usuario, bloquear
        if (!in_array($controller, $roles[$tipo])) {
            die("Acceso restringido.");
        }
    }


}
