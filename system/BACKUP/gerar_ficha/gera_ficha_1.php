<?php
$ficha_pagamento_id = filter_input(INPUT_GET, 'ficha_pagamento_id', FILTER_VALIDATE_INT);
if (!isset($_POST['visualizar_ficha'])):



    $listarficha = new Read;
    $listarficha->ExeRead("ficha_pagamento", "WHERE ficha_pagamento_id='$ficha_pagamento_id'");


//
//    $N_contrato = $listarficha->getResult()[0]['n_contrato'];
//    $ano_inscricao = $listarficha->getResult()[0]['ano_inscricao'];
//    $titular = $listarficha->getResult()[0]['titular_nome'];
//    $ano_inicial = $listarficha->getResult()[0]['ano_inicial'];
//    $ano_final = $listarficha->getResult()[0]['ano_final'];
//    $v_parcela = $listarficha->getResult()[0]['n_contrato'];
//    $n_parcela= $listarficha->getResult()[0]['valor_parcela'];
//    $mes_inicial = $listarficha->getResult()[0]['mes_inicial'];
//---------------------------------------------------------------------------
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="UTF-8">
        <link href="../../css/style_ficha4.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/style_ficha14.css"  rel="stylesheet" type="text/css">

    </head>
    <body>

        <div id="A4">
            <!--PRIMEIRA FICHA-->
            <div id="ficha">
                <div id="topo">
                    <img src="../../images/logoficha.JPG">
                    <h2>CONT Nº <b> </b> Nº DA INSCRIÇÃO <b></b></h2>
                    <br>
                    <h3 class="to-uppercase">Titular: <b></b> Periodo:<b></b></h3>
                </div>
                <div id="separador"></div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>

                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>

                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4">

                    </div>
                </div>

                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3> </h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>
                <div id="q1">
                    <h3></h3>
                    <div id="q2"></div>
                    <div id="q3"></div>
                    <div id="q4"></div>
                </div>


            </div>
            <!--FIM-DA-PRIMEIRA FICHA-->

            <div id="botoes">
                <!--BOTOES-->
<!--               <input type="button" class="botao" name="imprimir" value="Imprimir" onclick="window.print();">-->
                <!--BOTOES-->	

            </div>


        </div>




    </body>
</html>