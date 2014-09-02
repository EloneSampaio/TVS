<?php

/*
 * @sam
 */

class UsuarioController extends Controller {

    //put your code here
    private $usuario;

    public function __construct() {
        parent::__construct();
        $this->usuario = $this->LoadModelo("usuario");
    }

    public function index($pagina = FALSE) {
        
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }
           $this->view->setJs(array("novo"));


        $this->getBibliotecas('paginador');
        $paginador = new Paginador();
        $this->view->titulo = "Pagina de Usuarios";
        $this->view->link = "usuario/novo";
        $this->view->usuarios = $paginador->paginar($this->usuario->listarAll(), $pagina);
        $this->view->paginacion = $paginador->getView('paginacao', 'usuario/index');

        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('nome')) {
                $this->view->erro = "Porfavor Introduza um nome valido ";
                $this->view->renderizar("novo");
                exit;
            }


            if (!$this->getSqlverifica('login')) {
                $this->view->erro = "Porfavor Introduza um login valido ";
                $this->view->renderizar("novo");
                exit;
            }

            $c = $this->usuario->verificar_usuario($this->getSqlverifica('login'));
            if ($c) {
                $this->view->erro = "O usuario já esta registrado.";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('nivel')) {
                $this->view->erro = "Porfavor Selecciona um nivel para o usuario ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->alphaNumeric('senha')) {
                $this->view->erro = "Porfavor introduza uma senha valida para o  usuario ";
                $this->view->renderizar("novo");
                exit;
            }

            $data = array();
            $data['nome'] = $this->getSqlverifica('nome');
            $data['login'] = $this->getSqlverifica('login');
            $data['nivel'] = $this->getSqlverifica('nivel');
            $data['senha'] = $this->alphaNumeric('senha');

            $this->usuario->registrar($data);

            $usuario = $this->usuario->verificar_usuario($this->getSqlverifica('login'));
            if (!$usuario) {
                $this->view->erro = "Não Foi Possivel Possivel Concretizar a operção  tenta mais tarde!";
                $this->view->renderizar("index");
                exit;
            }

            $this->view->dados = FALSE;
            $this->view->mensagem = "Registro  Efectuado com Sucesso";
        }


        $this->view->renderizar("index");
    }

    function novo() {
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("style"));
        $this->view->footer = $this->getFooter('footer', 'index');
        $this->view->renderizar('novo');
    }

    public function editar($id) {

        Session::nivelRestrito(array("admin"));

        if (!$this->filtraInt($id)) {
            $this->redirecionar("usuario");
        }

        $this->view->dados = $this->usuario->listar_id($this->filtraInt($id));
        $this->view->titulo = "Editar Usuario";
        $this->view->setJs(array("novo"));

        if ($this->getInt("enviar")) {

            if (!$this->getSqlverifica('nome')) {
                $this->view->erro = "Porfavor Introduza um nome valido ";
                $this->view->renderizar("editar");
                exit;
            }


            if (!$this->getSqlverifica('login')) {
                $this->view->erro = "Porfavor Introduza um login valido ";
                $this->view->renderizar("editar");
                exit;
            }


            if (!$this->getSqlverifica('nivel')) {
                $this->view->erro = "Porfavor Selecciona um nivel para o usuario ";
                $this->view->renderizar("editar");
                exit;
            }

            $data = array();
            $data['nome'] = $this->getSqlverifica('nome');
            $data['login'] = $this->getSqlverifica('login');
            $data['nivel'] = $this->getSqlverifica('nivel');

            if (!isset($_POST['senha'])){
                $data['senha'] = $this->alphaNumeric('senha');
            }
            if (!$this->usuario->editar_usuario($data, $this->filtraInt($id))) {
                $this->view->erro = "Erro ao alterar dados ";
                $this->view->renderizar("editar");
                exit;
            }
            $this->view->mensagem = "Alteração feita com sucesso";
        }
        $this->view->renderizar("editar");
    }

    public function apagar($id) {
        Session::nivelRestrito(array("usuario"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("usuario");
        }

        if (!$this->usuario->listar_id($this->filtraInt($id))) {
            $this->redirecionar("usuario");
        }
        $this->usuario->apagar_usuario($this->filtraInt($id));
        $this->redirecionar("usuario");
    }

}
