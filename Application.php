<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;

class Application
{
    public string $userClass;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $requset;
    public Response $response;
    public Controller $controller;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;
    public static Application $app;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->requset = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->db = new Database($config['db']);
        $this->view = new View();
        $this->router = new Router($this->requset, $this->response);

        $value = $this->session->get('user');
        if($value) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $value]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exeption' => $e 
            ]);
        }
    } 

    public function getController()
    {
        return $this->controller;
    } 

    public function setController(Controller $controller)
    {
        $this->controller = $controller;    
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $className = get_class($user);
        $primaryKey = $className::primaryKey();
        $value = $user->{$primaryKey};
        $this->session->set('user', $value);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }
}