<?php
ob_start();
session_start();
require('_app/Config.inc.php');

$login = new Login(1, 1);

date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y');


$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()) :
    unset($_SESSION['usuario_nome']);
    header('location:index.php?exe=restrito');
else :
    $userlogin = $_SESSION['usuario_login'];
    $userlogin = $_SESSION['usuario_nome'];
    $userlogin = $_SESSION['usuario_nivel'];



endif;

if ($logoff) :
    unset($_SESSION['usuario_nome']);
    header('location:index.php?exe=logoff');
endif;
?>


<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title id="title"> SIS FUNERARIA VER 1.1</title>
    <link rel="stylesheet" type="text/css" href="css/painel.css">

    <!--        -OS LINKS  DO MENU PRINCIPA! -->
    <link type="text/css" href="Menu_Principal/menu.css" rel="stylesheet" />



    <!--OS LINKS  DO CSS!-->
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/admin.css" />
    <link rel="stylesheet" href="css/cadastrar_clientes.css">
    <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">
    <!--OS LINKS RESPONSAVEIS POR ATIVAR AS MASCARAS NOS INPUTS!-->



    <!--Mascara a serem inseridas nos inpus para adicionar uma mascara abaixo basta adicionar na propriedade do input a sua class respectica-->
    <!--exemplo  <input   class="cpf"   >-->




</head>


<body>



    <div id="menu">


        <li><a href="painel.php" class=""><span>HOME</span></a></li>

        <li><a href="#" class="parent"><span>LISTAR </span></a>
            <div>
                <ul>

                    <li><a href="painel.php?exe=listar/clientes/index"><span>Cliente</span></a></li>
                    <li><a href="#"><span>Dependente</span></a></li>

                    <li><a href="#"><span>Cemitério</span></a></li>
                    <li><a href="#"><span>Cartório</span></a></li>

                </ul>
            </div>

        </li>
       
        <li><a href="#" class="parent"><span>CADASTRAR/CONSULTAR </span></a>
            <div>
                <ul>

                    <li><a href="painel.php?exe=clientes/index"><span>Cliente</span></a></li>
                    <li><a href="painel.php?exe=dependentes/index"><span>Dependente</span></a></li>
                    <li><a href="painel.php?exe=ficha_de_pagamento/index"><span>Ficha De Pagamento</span></a></li>
                    <li><a href="painel.php?exe=cemiterio/index"><span>Cemitério</span></a></li>
                    <li><a href="painel.php?exe=cartorio/index"><span>Cartório</span></a></li>
                    <li><a href="#" class="parent"><span>Guia de Sepultamento</span></a>
                        <div>
                            <ul>
                                <li><a href="painel.php?exe=guia_de_sepultamento/particular/index"><span>Particular</span></a></li>
                                <li><a href="painel.php?exe=guia_de_sepultamento/titular/index"><span>Titular plano</span></a></li>
                                <li><a href="painel.php?exe=guia_de_sepultamento/dependentes/index"><span>Dependentes</span></a></li>


                            </ul>
                        </div>

                    </li>
                </ul>
            </div>

        </li>




        <li><a href="#" class="parent"><span>GERAR FICHA</span></a>
            <div>
                <ul>
                    <li><a href="#" class="parent"><span>COM CPF</span></a>
                        <div>
                            <ul>
                                <li><a href="painel.php?exe=gerar_ficha/1_ficha"><span>1 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/2_ficha"><span>2 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/3_ficha"><span>3 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/4_ficha"><span>4 FICHA</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="#" class="parent"><span>CPF E NÚMERO DA FICHA</span></a>
                        <div>
                            <ul>
                                <li><a href="painel.php?exe=gerar_ficha/1_ficha_com_numero"><span>1 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/2_ficha_com_numero"><span>2 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/3_ficha_com_numero"><span>3 FICHA</span></a></li>
                                <li><a href="painel.php?exe=gerar_ficha/4_ficha_com_numero"><span>4 FICHA</span></a></li>
                            </ul>
                        </div>
                    </li>


                </ul>
            </div>
        </li>
        <li><a href="#" class="parent"><span>DOCUMENTOS</span></a>
            <div>
                <ul>
                    <li><a href="painel.php?exe=recibo/index" class=""><span>RECIBO</span></a></li>
                    <li><a href="painel.php?exe=contrato/index" class=""><span>CONTRATO</span></a></li>
                    <li><a href="painel.php?exe=pedido_de_inscricao/index"><span>PEDIDO DE INSCRIÇÃO</span></a></li>
                    <li><a href="painel.php?exe=gerador_de_guia_sepultamento/index"><span>GUIA DE DESULTAMENTO</span></a></li>
                    <li><a href="painel.php?exe=ficha_de_pagamento/index"><span>FICHA DE PAGAMENTO</span></a></li>
                    <li><a href="painel.php?exe=carne_de_pagamento/index"><span>CARNE</span></a></li>


                </ul>
            </div>
        </li>

        <li><a href="painel.php?logoff=true" class=""><span>SAIR</span></a></li>




    </div>

    <div id="painel">
        <?php
        //QUERY STRING
        if (!empty($getexe)) :
            $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
        else :
            $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
        endif;

        if (file_exists($includepatch)) :
            require_once($includepatch);
        else :
            echo "<div class=\"content notfound\">";
            WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
            echo "</div>";
        endif;
        ?>
    </div> <!-- painel -->


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="_cdn/jquery.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="_cdn/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="_cdn/input_mascara.js" type="text/javascript"></script>

    <script src="_cdn/combo.js"></script>

    <script src="__jsc/tiny_mce/tiny_mce.js"></script>
    <script src="__jsc/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>



</body>

</html>
<?php
ob_end_flush();
