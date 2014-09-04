<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoriaController
 *
 * @author sam
 */
class DashboardController extends Controller {

    //put your code here
    private $dashboards;
    private $clientes;
    private $pagamentos;

    public function __construct() {
        parent::__construct();

        $this->dashboards = $this->LoadModelo("usuario");
        $this->clientes = $this->LoadModelo("cliente");
        $this->pagamentos = $this->LoadModelo("pagamento");
    }

    public function index() {
        $this->view->setJs(array("novo"));
        Session::nivelRestrito(array("usuario", "admin"), TRUE);
        $this->view->footer = $this->getFooter('footer', 'index');
        $this->view->t = $this->dashboards->listarUltimos();
        $this->view->titulo = "Pagina de Administracção";
        $this->view->renderizar('index');
    }

    public function listarUsuario() {
        $this->view->titulo = "Usuarios";
        $this->view->usuarios = $this->dashboards->listarUltimos();
        $this->view->clientes = $this->clientes->listarUltimos();
        $this->view->pagamentos = $this->pagamentos->listarUltimos();
        
        $this->view->renderizar('st');
    }

}
