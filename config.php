<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("URL", "http://localhost:8080/Tvs/");
define("DEFAULT_LAYOUT", "default");
define("APP_NAME", "Programao Angola");
define("APP_DESCRICAO", "Trabalhando Para Melhorar O Conceito de Programação em Angola");
define("DESENVOLVEDOR", "SamEngenner");
define("COMPANY", "Sam&&Eletronicos");
define("SESSION_TIME", "30");
define("HASH_KEY", "peixede234luanda1298");
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__FILE__)) . DS);
define("APP_PATH", ROOT . "application" . DS);
define("DEFAULT_ERRO", "errorController");
define('Valor_Inicio', 125436778);
define('Valor_Final',88888888);
define('SMS', "FOI EFECTUADO UM NOVO PAGAMENTO PELO Cliente:");
define('SMSCLIENTE', "OBRIGADO POR TER FEITO O PAGAMENTO:");
define('TELEFONE', 927303154);

require APP_PATH . "Bootstrap.php";
require APP_PATH . "Controller.php";
require APP_PATH . "Database.php";
require APP_PATH . "Hash.php";
require APP_PATH . "Model.php";
require APP_PATH . "Session.php";
require APP_PATH . "View.php";
require APP_PATH . "Request.php";
require APP_PATH . "Config.php";
require APP_PATH . "Sms.php";
//require APP_PATH."Acl.php";