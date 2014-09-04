<?php

/*
 * @sam
 */

class SmsController extends Controller {

    //put your code here
    private $clientes;

    public function __construct() {
        parent::__construct();
        $this->clientes = $this->LoadModelo("cliente");
    }

    function index() {

        //print_r($_POST); exit;
        $this->view->setJs(array("bootstrap-multiselect"));
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("bootstrap-multiselect"));

        $this->view->titulo = "Envio de Mensagens para Clientes";
        $this->view->nome = $this->clientes->verificar_nome();

        if ($this->getInt('enviar') == 1) {

            if (!$this->getSqlverifica('mensagem')) {
                $this->view->erro = "Porfavor introduza uma mensagem valida ";
                $this->view->renderizar("index");
                exit;
            }


            $cliente = $this->clientes->verifcar_tel($_POST['telefone']);
            if (!$cliente) {
                $this->view->erro = "O Contacto que pretende enviar sms não esta registrado!";
                $this->view->renderizar("index");
                exit;
            }
            $telefone = implode(",", $_POST['telefone']);

            if (Sms::SendSMS("127.0.0.1", 8800, "", "", $telefone, $this->getSqlverifica('mensagem'))) {
                $this->view->mensagem = "Mensagem Enviada com Sucesso";
            } else {
                $this->view->erro = "Erro ao Enviar Mensagem";
            }


            $this->view->dados = FALSE;
        }


        $this->view->renderizar("index");
    }

}
