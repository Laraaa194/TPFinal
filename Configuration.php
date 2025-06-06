<?php
const BASE_URL = '/TPFinal/';

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

require_once("model/LoginModel.php");
require_once("model/RegisterModel.php");
require_once("model/PerfilModel.php");
require_once("model/PreguntaModel.php");
require_once("model/PartidaModel.php");
require_once ("model/PartidaPreguntaModel.php");
require_once ("model/PreguntaUsuarioModel.php");
require_once ("model/UsuarioModel.php");

include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    public function getDatabase()
    {
        $config = $this->getIniConfig();
        $config = $this->getIniConfig();

        return new Database(
            $config["database"]["server"],
            $config["database"]["user"],
            $config["database"]["dbname"],
            $config["database"]["pass"]
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
        (new PerfilModel($this->getDatabase()), $this->getViewer());
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
        return new ResultadoController
        ($this->getViewer());
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
}