<?php

/**
 * Description of categoriaModel
 *
 * @author sam
 */
class pagamentoModel extends Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function registrar($data) {
        $novo = $this->db->Inserir(
                "pagamentos", array(
            'data' => date('Y-m-d'),
            'mes' => $data['mes'],
            'status' => 'on',
            'id_usuario' => Session::get('id_usuario'),
            'id_cliente' => $data['id_cliente']
        ));
    }

    public function listarAll() {
        return $this->db->Selecionar('SELECT * FROM clientes c INNER JOIN pagamentos p ON c.id = p.id_cliente
WHERE p.status =  "on" ORDER BY p.id DESC');
    }

    public function listarUltimos() {
        return $this->db->Selecionar('SELECT * FROM pagamentos c INNER JOIN usuarios p ON c.id_usuario = p.id_usuario 
 ORDER BY c.id DESC LIMIT 3');
    }

    public function Verificar_mes($mes, $id) {
        $em = $this->db->prepare("SELECT * FROM pagamentos WHERE mes=:mes AND id_cliente=:id_cliente");

        $em->execute(array(
            ':mes' => $mes,
            ':id_cliente' => $id
        ));
        return $em->fetch();
    }

    public function listarDivida() {
        return $this->db->Selecionar('SELECT * FROM pagamentos WHERE status=on');
    }

//fim
}
