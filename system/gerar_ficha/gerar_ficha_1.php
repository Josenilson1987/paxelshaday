<?php
require '../../_app/Config.inc.php';
require '../../_models/AdminFicha.class.php';



$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


$data["cpf_titular_1"] = str_replace([".", "-"], "", $data["cpf_titular_1"]); // 00000000000﻿


$n_ficha_1 = $data["n_ficha_1"];



if ($n_ficha_1 > 0):
    $listarficha1 = new Read;
    $listarficha1->FullRead("select * from ficha_pagamento where cpf={$data["cpf_titular_1"]} AND numero_ficha= {$n_ficha_1} order by numero_ficha desc limit 1");
    
   
else:
    $listarficha1 = new Read;
    $listarficha1->FullRead("select * from ficha_pagamento where cpf={$data["cpf_titular_1"]} order by numero_ficha desc limit 1");
    
   
endif;







//var_dump($listarficha1);
//var_dump($listarficha2);
//var_dump($listarficha3);
//var_dump($listarficha4);
// INICIO DAS FUNÇÕES DESTINADAS AO PRIMEIRO FORMULÁRIO
if (isset($_POST['gerar_ficha'])):

    $N_contrato = $listarficha1->getResult()[0]['n_contrato'];
    $ano_inscricao = $listarficha1->getResult()[0]['ano_inscricao'];
    $titular = $listarficha1->getResult()[0]['titular_nome'];
    $ano_inicial = $listarficha1->getResult()[0]['ano_inicial'];
    $ano_final = $listarficha1->getResult()[0]['ano_final'];
    $v_parcela = $listarficha1->getResult()[0]['valor_parcela'];
    $n_parcela = $listarficha1->getResult()[0]['parcela_01'];
    $mes_inicial = $listarficha1->getResult()[0]['mes_inicial'];



//---------------------------------------------------------------------------

endif;

//CONTADOR DE PARCELAS  

$contador1 = 1;
$contador2 = 2;
$contador3 = 3;
$contador4 = 4;
$contador5 = 5;
$contador6 = 6;
$contador7 = 7;
$contador8 = 8;
$contador9 = 9;
$contador10 = 10;
$contador11 = 11;

//MESES  

$a = "janeiro";
$b = "fevereiro";
$c = "marco";
$d = "abril";
$e = "maio";
$f = "junho";
$g = "julho";
$h = "agosto";
$i = "setembro";
$j = "outubro";
$l = "NOVnovembro";
$m = "dezembro";

$v1 = array("JANEIRO", "FEVEREIRO", "MARO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO",);


if ($mes_inicial == "$a") {
    $v1 = array("JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO",);
} else {

    if ($mes_inicial == "$b") {
        $v1 = array("FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO",);
    }

    if ($mes_inicial == "$c") {
        $v1 = array("MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO",);
    }

    if ($mes_inicial == "$d") {
        $v1 = array("ABRIL", "MAIO", "JUNHO", "JUNHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO",);
    }

    if ($mes_inicial == "$e") {
        $v1 = array("MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL",);
    }

    if ($mes_inicial == "$f") {
        $v1 = array("JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO",);
    }

    if ($mes_inicial == "$g") {
        $v1 = array("JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO",);
    }

    if ($mes_inicial == "$h") {
        $v1 = array("AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO",);
    }

    if ($mes_inicial == "$i") {
        $v1 = array("SETEMBRO", "OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO",);
    }

    if ($mes_inicial == "$j") {
        $v1 = array("OUTUBRO", "NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO",);
    }

    if ($mes_inicial == "$l") {
        $v1 = array("NOVEMBRO", "DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO",);
    }

    if ($mes_inicial == "$m") {
        $v1 = array("DESEMBRO", "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGOSTO", "SETEMBRO", "OUTUBRO", "NOVEMBRO",);
    }
}
// FIM DAS FUNÇÕES DESTINADAS AO PRIMEIRO FORMULÁRIO
?>



<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="../../css/style_ficha4.css">

    </head>
    <body>

        <div id="A4">
            <!--PRIMEIRA FICHA-->
            <div id="ficha">
                <div id="topo">
                    <img src="../../images/logoficha.JPG">
                    <h2>CONT Nº <b> <?php echo "$N_contrato"; ?></b> Nº DA INSCRIÇÃO <b><?php echo "$ano_inscricao"; ?></b></h2>
                    <br>
                    <h3 class="to-uppercase">Titular:  <b><?php echo "$titular"; ?></b> Periodo:<b><?php echo "$ano_inicial A $ano_final"; ?></b></h3>
                </div>
                <div id="separador"></div>
                <div id="q1">
                    <h3><?php echo "$v1[0]" ?></h3>
                    <div id="q2"><?php echo $n_parcela ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>

                <div id="q1">
                    <h3><?php echo " $v1[1]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador1 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>

                <div id="q1">
                    <h3><?php echo " $v1[2]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador2 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4">

                    </div>
                </div>

                <div id="q1">
                    <h3><?php echo " $v1[3]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador3 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[4]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador4 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3> <?php echo " $v1[5]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador5 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[6]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador6 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo "$v1[7]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador7 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[8]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador8 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[9]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador9 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[10]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador10 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3><?php echo " $v1[11]" ?></h3>
                    <div id="q2"><?php echo $n_parcela + $contador11 ?></div>
                    <div id="q3"><?php echo "R$ $v_parcela" ?></div>
                    <div id="q4"></div>
                </div>


            </div>
            <!--FIM-DA-PRIMEIRA FICHA-->

           

            </div>

            <div id="botoes">
                <!--BOTOES-->
                <input type="button" class="botao" name="imprimir" value="Imprimir" onclick="window.print();">
                <!--BOTOES-->	

            </div>


      




    </body>
</html>