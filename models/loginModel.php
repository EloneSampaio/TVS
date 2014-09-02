<?php


/**
 * Description of Login_Model
 *
 * @author sam
 */
class loginModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function login($dados) {

        $novo = $this->db->prepare("SELECT *FROM usuarios WHERE login=:login AND senha=:senha");
        $novo->execute(array(
            ':login' => $dados['nome'],
            ':senha' =>Hash::getHash('md5', $dados['senha'], HASH_KEY)  //$dados['senha'] 
        ));
        return $novo->fetch();
    }

//fim
}
