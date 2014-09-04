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
class PagamentoController extends Controller {

    //put your code here
    private $pagamentos;
    private $clientes;

    public function __construct() {
        parent::__construct();
        $this->pagamentos = $this->LoadModelo("pagamento");
        $this->clientes = $this->LoadModelo("cliente");
    }

    public function index($pagina = FALSE) {
        if (!$this->filtraInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }

        if (!Session::get('autenticado')) {
            $this->redirecionar();
        }
        $this->view->setJs(array("novo"));

        $this->getBibliotecas('paginador');
        $paginador = new Paginador();

        $this->view->titulo = "Pagamentos Efectuados";
        $this->view->pagamentos = $paginador->paginar($this->pagamentos->listarAll(), $pagina);
        $this->view->paginacion = $paginador->getView('paginacao', 'pagamento/index');

        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getInt('codigo')) {
                $this->view->erro = "Porfavor Introduza um codigo valido ";
                $this->view->renderizar("novo");
                exit;
            }

            $c = $this->clientes->verificar_codigo($this->getInt('codigo'));
            if (!$c) {
                $this->view->erro = "O cliente não esta registrado, porfavor registra-o primeiro antes do pagamento";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('mes')) {
                $this->view->erro = "Porfavor Selecciona um mes valido ";
                $this->view->renderizar("novo");
                exit;
            }

            $data = array();
            $data['codigo'] = $this->getInt('codigo');
            $data['mes'] = $this->getSqlverifica('mes');
            $data['id_cliente'] = $c['id'];



            $pagamento = $this->pagamentos->verificar_mes($this->getSqlverifica('mes'), $c['id']);
            if ($pagamento) {
                $this->view->mensagem = "Este Mes já foi Pago!";
                $this->view->renderizar("index");
                exit;
            }

            $this->pagamentos->registrar($data);
            if (!$this->pagamentos->verificar_mes($this->getSqlverifica('mes'), $c['id'])) {
                $this->view->erro = "Não Foi Possivel Possivel Concretizar a operção  tenta mais tarde";
                $this->view->renderizar("novo");
                exit;
            }

            $mensagem = SMS . $c['nome'] . "Para o mes de " . $this->getSqlverifica('mes') . "Data:" . date('Y-m-d H:i:s');
            //Enviar a mensagem para administrador
            Sms::SendSMS("127.0.0.1", 8800, "", "", $c['telefone'], $mensagem.PADRAO);
            //Enviar a mensagem para cliente
            Sms::SendSMS("127.0.0.1", 8800, "", "", TELEFONE, SMSCLIENTE);
            $this->view->dados = FALSE;
            $this->view->mensagem = "Pagamento Efectuado com Sucesso";
        }

        $this->view->renderizar("index");
    }

    function novo() {
        $this->view->setJs(array("novo"));
        $this->view->setCss(array("style"));
        $this->view->footer = $this->getFooter('footer', 'index');
        $this->view->renderizar('novo');
    }

}
