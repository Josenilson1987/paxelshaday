<?php
session_start();

require('../../_app/Config.inc.php');

$login = new Login(1,2,3);

if (!$login->CheckLogin()):
    unset($_SESSION['usuario_nome']);
    header('Location: ../../painel.php');
else:
    $userlogin = $_SESSION['usuario_login'];
endif;


if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


//var_dump($data);
?> 


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../../css/style_recibo.css"/>
        <link rel="stylesheet" href="../../_app/bootstrap/css/bootstrap.min.css">
        <meta charset="UTF-8"/>
        <title>RECIBO</title>




        <style media="print">
            .botao {display: none;}

        </style>

    </head>
    <body>





        <div class="recibo">

            <div id="logo">

                <img src="../../images/logoficha.JPG">
            </div>

            <div id="valor">
                <h2><?= $data["valor_recibo"] ?></h2>

            </div>


            <div id="nome_valor">
                <span class="style2">VALOR</span>:    
            </div>
            <div class="style1" id="nome_recibo">RECIBO:</div>

            <div id="corpo">


                <?php
                echo "<B>A FUNERÁRIA PAX EL SHADAY RECEBEU DO SR: {$data["responsavel"]} INSCRITO PELO CPF:  {$data["cpf_responsavel"]} A IMPORTÂNCIA DE {$data["extenso"]} REAIS REFERENTE A UM SERVIÇO FUNERAL DO
        SR:(A)  {$data["falecido"]} FALECIDO EM {$data["data_falecimento"]} </B>";
                ?>



            </div>


            <div id="data_atual">

                <?php
                echo "SALVADOR-BA {$data["data_atual"]}";
                ?>

                <div id="linha">
                    ASS:____________________________________
                </div>


            </div>

            <div id="pax_responsavel">

                <?php
                ECHO $responsavel = "Jose Pereira Filho"
                ?>
            </div>


            <div ID="botoes" class="botao" >
              



                <button name="print" type="button" class="btn btn-default" onclick="window.print();">IMPRIMIR <span class="glyphicon glyphicon-print" aria-hidden="true"></span> <!--ICONE NO BOTÃO--></button>

                <button type="button" value="" class="btn btn-primary" onClick="JavaScript: window.history.back();">
                    CORRIGIR RECIBO<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                </button>
                <a href="../../painel.php?exe=recibo/index" class="btn btn-success" >NOVO RECIBO</a>
          
            </div>

        </div>











    </body>
</html>
