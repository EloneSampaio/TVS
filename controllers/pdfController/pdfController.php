<?php

class pdfController extends Controller {

    private $pdf;
    private $clientes;

    public function __construct() {
        parent::__construct();
        $this->clientes = $this->LoadModelo("cliente");
        $this->pagamentos = $this->LoadModelo("pagamento");
        ob_start();
        $this->getBibliotecas('mpdf/mpdf');
        define("_MPDF_PATH", ROOT . DS . "libs" . DS . "mpdf" . DS);
        $this->pdf = new mPDF();
        $this->view->titulo = "factura";
    }

    public function index() {
        
    }

    public function contrato($codigo) {
        if (!$this->filtraInt($codigo)) {
            $codigo = false;
        } else {
            $codigo = (int) $codigo;
        }
        $this->view->titulo = "imprimir contrato";
        $stylesheet = file_get_contents(ROOT . "views" . DS . "layout" . DS . DEFAULT_LAYOUT . DS . "bootstrap" . DS . "css" . DS . "bootstrap.min.css");
        $html = $this->getRelatorio('contrato');
        $cl = $this->clientes->verificar_codigo($codigo);
        $this->pdf->allow_charset_conversion = true;
        $this->pdf->charset_in = 'UTF-8';
        $this->pdf->SetDisplayMode('fullpage');
        $data = "<p style='text-align:right;'>Codigo do Cliente :" . $cl['codigo'] . "</p>";

        $this->pdf->WriteHTML($stylesheet, 1);

        $this->pdf->WriteHTML($html);
        $this->pdf->WriteHTML($data);
        $arquivo = $cl['codigo'];
        $this->pdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|TV-S / contrato');
        $this->pdf->Output($arquivo, "I");

        exit();
    }

    public function factura($mes, $id) {
        if (!$this->filtraInt($codigo)) {
            $codigo = false;
        } else {
            $codigo = (int) $codigo;
        }
        $this->view->titulo = "imprimir factura";
        $stylesheet = file_get_contents(ROOT . "views" . DS . "layout" . DS . DEFAULT_LAYOUT . DS . "bootstrap" . DS . "css" . DS . "relatorio.css");
        //$html = $this->getRelatorio('factura');
        $cl = $this->pagamentos->verificar_mes($mes, $id);
        $cli = $this->clientes->listar_id($cl['id_cliente']);

        $this->pdf->allow_charset_conversion = true;
        $this->pdf->charset_in = 'UTF-8';
        $this->pdf->SetDisplayMode('fullpage');

        $texto = "<div id='linha'>" .
                  "<hr>".
                "<table border='2'><tr><th width='120'>Cliente</th><th width='120'>Meses</th><th width='120'>Total</th></tr>" .
                "<tbody>" .
              
                "<tr>"
                
                . "<td>" . $cli['nome'] . "</td>" .
                "<td>5000.00</td>" .
                "<td>" . $cl['mes'] . "</td>" .
                "</tr></tbody></table>" .
                "</div> <br /><br /><br /><br /><br /><br />";


        $rodape = "<div id='quadro'><p id='texto'>Estimado cliente preserve sempre o ultimo recibo do mes pago,acompanhe-se sempre do seu recibo anterior seja penultimo ou ultimo.</p><br />"
                . "<p id='texto'>Lembre-se a TV-S já não atenuará atrasos acima de 15 dias, no caso em que o cliente não consultar a direcção, ou no facto da direcção não conceder o atraso. Em caso de falha no sinal entre em contacto connosco pelos numeros abaixos referenciados."
                . " </p>"
                . "</div>";

        $this->pdf->WriteHTML($stylesheet, 1);
        $this->pdf->WriteHTML($texto);
        $this->pdf->WriteHTML($rodape);

        $arquivo = $cl['codigo'];
        $this->pdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|TV-S Liga-nos/contactos:/927303154 /22222/ (recibo)');
        $this->pdf->Output($arquivo, "I");

        exit();
    }

    public function cliente() {
        $this->view->titulo = "imprimir clientes";
        $cl = $this->clientes->listarAll();
        $this->pdf->allow_charset_conversion = true;
        $this->pdf->charset_in = 'UTF-8';
        $this->pdf->SetDisplayMode('fullpage');
        $titulo = "<h2 style='text-align:center;'>Lista de Clientes</h2>";
        $this->pdf->WriteHTML($titulo);
        foreach ($cl as $valor):
//         
            $h = "<hr>";
            $nome = "<p>Nome :" . $valor['nome'] . "</p>";
            $tel = "<p>Telefone :" . $valor['telefone'] . "</p>";
            $codigo = "<p>Codigo :" . $valor['codigo'] . "</p>";
            $this->pdf->WriteHTML("$nome");
            $this->pdf->WriteHTML("$tel");
            $this->pdf->WriteHTML("$codigo");
            $this->pdf->WriteHTML("$h");
        endforeach;

        $this->pdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|TV-S / clientes');
        $arquivo = "cliente";
        $this->pdf->Output($arquivo, "I");
    }

}

?>
