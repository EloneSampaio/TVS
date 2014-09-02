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

    public function index() {

        $this->view->titulo = "Envio de Mensagens para Clientes";

        $contactos = $this->clientes->listarContactos();

        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('mensagem')) {
                $this->view->erro = "Porfavor introduza uma mensagem valida ";
                $this->view->renderizar("index");
                exit;
            }


            for ($i = 0; $i < count($contactos); $i++) {
                if (Sms::SendSMS("127.0.0.1", 8800, "", "", $contactos, $this->getSqlverifica('mensagem'))) {
                    $this->view->mensagem = "Mensagem Enviada com Sucesso";
                } else {
                    $this->view->erro = "Erro ao Enviar Mensagem";
                }
            }


            $this->view->dados = FALSE;
        }


        $this->view->renderizar("index");
    }

    function novo() {

        //print_r($_POST); exit;
        $this->view->titulo = "Envio de Mensagens para Clientes";
         $this->view->nome=$this->clientes->verificar_nome();

        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;




            if (!$this->getInt('telefone')) {
                $this->view->erro = "Porfavor introduza uma contacto valido ";
                $this->view->renderizar("novo");
                exit;
            }


            if (!$this->getSqlverifica('mensagem')) {
                $this->view->erro = "Porfavor introduza uma mensagem valida ";
                $this->view->renderizar("novo");
                exit;
            }


            $cliente = $this->clientes->verifcar_cliente($this->getInt('telefone'));
            if (!$cliente) {
                $this->view->erro = "O COntacto que pretende enviar sms não esta registrado!";
                $this->view->renderizar("novo");
                exit;
            }
            
           
          
            if (Sms::SendSMS("127.0.0.1", 8800, "", "", $this->getInt('telefone'), $this->getSqlverifica('mensagem'))) {
                $this->view->mensagem = "Mensagem Enviada com Sucesso";
            } else {
                $this->view->erro = "Erro ao Enviar Mensagem";
            }


            $this->view->dados = FALSE;
        }


        $this->view->renderizar("novo");





        //            $mensagem = SMS . $c['nome'] . "Para o mes de " . $this->getSqlverifica('mes') . "Data:" . date('Y-m-d H:i:s');
//Enviar a mensagem para cliente
    }

}
