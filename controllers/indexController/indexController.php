<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author sam
 */
class IndexController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        if (!Session::get('autenticado')) {
//            $this->redirecionar('login');
//        }
        $this->view->titulo = "Pagina Incial";
        if (!Session::get('autenticado')) {
            $this->redirecionar('login');
        }
//        $this->view->setCss(array("css"));
       $this->view->footer = $this->getFooter('footer', 'index');
        $this->view->renderizar("index");
    }

}
