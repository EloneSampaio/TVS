<?php

/**
 * Description of registrarController
 *
 * @author sam
 */
class ClienteController extends Controller {

    //put your code here

    private $cliente;

    public function __construct() {
        $this->cliente = $this->LoadModelo('cliente');
        parent::__construct();
    }

    public function index($pagina = FALSE) {

        $this->view->setJs(array("novo"));
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }

        if (!Session::get('autenticado')) {
            $this->redirecionar();
        }
      

        $this->getBibliotecas('paginador');
        $paginador = new Paginador();

        $this->view->titulo = "Clientes Cadastrado";
        $this->view->clientes = $paginador->paginar($this->cliente->listarAll(), $pagina);
        $this->view->paginacion = $paginador->getView('paginacao', 'cliente/index');


        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('p_nome')) {
                $this->view->erro = "Porfavor Introduza o primeiro nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('u_nome')) {
                $this->view->erro = "Porfavor Introduza o segundo nome do cliente ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('morada')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getInt('telefone')) {
                $this->view->erro = "POrfavor Introduza um contacto  valido";
                $this->view->renderizar("novo");
                exit;
            }

            $data = array();
            $data['p_nome'] = $this->getSqlverifica('p_nome');
            $data['u_nome'] = $this->getSqlverifica('u_nome');
            $data['telefone'] = $this->getInt('telefone');
            $data['morada'] = $this->getSqlverifica('morada');
            $data['nome'] = $data['p_nome'] . " " . $data['u_nome'];


            $cliente = $this->cliente->verifcar_cliente($this->filtraInt($_POST['telefone']));
            if ($cliente) {
                $this->view->mensagem = "A conta que pretende criar já Existe !";
                $this->view->renderizar("index");
                exit;
            }

            if ($this->cliente->registrar($data)) {

                $this->view->dados = FALSE;
                $this->view->mensagem = "A sua conta foi criada com Sucesso";
            }
            if (!$this->cliente->verifcar_cliente($this->getInt('telefone'))) {
                $this->view->erro = "Não Possivel criar sua conta tenta mais tarde";
                $this->view->renderizar("novo");
                exit;
            }
        }

        //só se activa se o javascript estiver desabilitado 
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
            $this->redirecionar("cliente");
        }

        if (!$this->cliente->listar_id($this->filtraInt($id))) {
            $this->redirecionar("cliente");
        }


        $this->view->titulo = "Editar Cliente";
        $this->view->setJs(array("novo"));

        if ($this->getInt('envia') == 1) {


            if (!$this->getSqlverifica('nome')) {
                $this->view->erro = "Porfavor Introduza um nome do cliente valido";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('morada')) {
                $this->view->erro = "POrfavor Introduza um endereço ou morada  valido";
                $this->view->renderizar("novo");
                exit;
            }

            $data = array();
            $data['telefone'] = $this->getInt('telefone');
            $data['morada'] = $this->getSqlverifica('morada');
            $data['nome'] = $this->getSqlverifica('nome');
            $this->cliente->editar_cliente($data,$this->filtraInt($id));
            $this->view->dados = $this->view->mensagem = "Alterado com Sucesso";
        }

        $this->view->dados = $this->cliente->listar_id($this->filtraInt($id));
        $this->view->renderizar("editar");
    }

    public function apagar($id) {
    
        Session::nivelRestrito(array("admin"));
        if (!$this->filtraInt($id)) {
            $this->redirecionar("cliente");
        }

        if (!$this->cliente->listar_id($this->filtraInt($id))) {
            $this->redirecionar("cliente");
        }
        $this->cliente->apagar_cliente($this->filtraInt($id));
        $this->redirecionar("cliente");
    }

}
