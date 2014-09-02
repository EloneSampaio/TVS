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
class usuarioModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function registrar($data) {
        $this->db->Inserir("usuarios", array(
            'nome' => $data['nome'],
            'login' => $data['login'],
            'senha' => Hash::getHash('md5', $data['senha'], HASH_KEY),
            'nivel' => $data['nivel'],
            'status' => 'on'
        ));
    }

    public function listarAll() {
        return $this->db->Selecionar('SELECT * FROM usuarios ORDER BY id_usuario DESC');
    }

    public function listarUltimos() {
        return $this->db->Selecionar('SELECT * FROM  usuarios ORDER BY  id_usuario DESC LIMIT 3');
    }

    public function Verificar_usuario($login) {
        return $this->db->Selecionar('SELECT  * FROM usuarios WHERE login=:login', array(':login' => $login));
    }

    public function listar_id($id) {
        return $this->db->Selecionar('SELECT  * FROM usuarios WHERE id_usuario=:id ', array(':id' => $id));
    }

    public function apagar_usuario($id) {
        $this->db->apagar('usuarios', "id_usuario = '$id'");
    }

    public function editar_usuario($data, $id) {

        $data = array(
            'nome' => $data['nome'],
            'login' => $data['login'],
            'nivel' => $data['nivel'],
            'status' => 'on'
        );
        if (in_array('senha', $data)) {
            $data = array('senha' => Hash::getHash('md5', $data['senha'], HASH_KEY));
        }
        return $this->db->Actualizar('usuarios', $data, "id_usuario={$id}");
    }

}
