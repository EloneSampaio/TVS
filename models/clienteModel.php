<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registrarModel
 *
 * @author sam
 */
class clienteModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function registrar($data) {
        $codigo = rand(Valor_Inicio, Valor_Final);
        $this->db->Inserir("clientes", array(
            'nome' => $data['nome'],
            'telefone' => $data['telefone'],
            'morada' => $data['morada'],
            'data' => date("Y-m-d"),
            'codigo' => $codigo
        ));
    }

    public function verifcar_cliente($tel) {

        return $this->db->Selecionar('SELECT  * FROM clientes WHERE telefone=:telefone ', array(':telefone' => $tel));
    }

    public function verifcar_tel($tel) {

        $tel = implode(",", $tel);
        $em = $this->db->prepare("SELECT telefone FROM clientes WHERE telefone IN (" . $tel . ")");
        $em->execute();
        return $em->fetch();
    }

    public function listar_id($id) {
        $em = $this->db->prepare("SELECT * FROM clientes WHERE id=:id");

        $em->execute(array(
            ':id' => $id,
        ));
        return $em->fetch();
    }

    public function verificar_codigo($codigo) {

        $em = $this->db->prepare("SELECT * FROM clientes WHERE codigo=:codigo");

        $em->execute(array(
            ':codigo' => $codigo,
        ));
        return $em->fetch();
    }

    public function verificar_nome() {
        return $this->db->Selecionar('SELECT nome,telefone FROM clientes');
    }

//fim

    public function listarAll() {
        return $this->db->Selecionar('SELECT * FROM clientes ORDER BY id DESC');
    }

    public function listarContactos() {
        return $this->db->Selecionar('SELECT telefone FROM clientes');
    }

    public function listarUltimos() {
        return $this->db->Selecionar('SELECT * FROM  clientes ORDER BY  id DESC LIMIT 3');
    }

    public function apagar_cliente($id) {
        $this->db->apagar('clientes', "id = '$id'");
    }

    public function editar_cliente($data, $id) {

        $data = array(
            'nome' => $data['nome'],
            'telefone' => $data['telefone'],
            'morada' => $data['morada'],
        );
        $this->db->Actualizar('clientes', $data, "id={$id}");
    }

}
