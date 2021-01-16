<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
header('Location: ../painel.php');
die;
endif;

$userlogin['empresa_cnpj'];

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($data['SendPostForm'])):
unset($data['SendPostForm']);

$data["titular_cpf"] = str_replace([".", "-"], "", $data["titular_cpf"]); // 00000000000﻿
$data["dependente_nome"] ;



// REALIZA UMA CONSULTA NA TABELA TITULAR E RETORNO ATRAVÉS DO CPF O NOME DO TITULAR
$titular_cpf = $data["titular_cpf"];
$verifica_cpf_titular = new Read;
$verifica_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$titular_cpf'");



// CONSULTA VERIFICA SE JÁ EXITE UM NOME NA TABELA DEPENDENTES
$dependente_nome = $data["dependente_nome"];
$verifica_dependente_nome = new Read;
$verifica_dependente_nome->ExeRead("dependentes", "WHERE  dependente_nome='$dependente_nome'");

if (count($verifica_cpf_titular->getResult()) === 0):
 WSErro("O CPF  do <b>Titular</b> informado não está cadastrado como titular, por favor informe um CPF valido .", WS_INFOR);   
 else:
  
if ($verifica_cpf_titular->getResult()[0]['lixeira'] > 0):
WSErro("Já existe um cadastro com o CPF: <b>Titular</b> informado,  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro . ", WS_INFOR);

elseif (($verifica_dependente_nome->getResult())):

if ($verifica_dependente_nome->getResult()[0]['dependente_lixeira'] > 0):
WSErro("Já existe um cadastro com o cpf de <b>Dependente</b> informado,  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro . ", WS_INFOR);
else:
header('Location: painel.php?exe=dependentes/update&update=true&dependentes_id=' . $verifica_dependente_nome->getResult()[0]['dependentes_id']);

endif;
else:
header('Location: painel.php?exe=dependentes/create&create=&titular_cpf=' . $data['titular_cpf'] .'&titular_nome=' . $verifica_cpf_titular->getResult()[0]['titular_nome']. '&dependente_nome=' . $data['dependente_nome'] );
endif;     
    
endif;
endif;

?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>



        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="css/cadastrar_dependentes.css">

        <script src="_cdn/jquery-2.1.1.min.jsss"></script>
        <script type="text/javascript" src="_cdn/mascaratelefone.js"></script>


    </head>

    <body>




        <div class="content form_create">
            <article>

                <div class="well well-lg Form_cliente form-inline content form_create " >

                    <form class="uppercase" name="Formcliente" action="" method="post" >


                        <legend>Cadastrar  Dependentes


                            <input  required class="form-control to-uppercase cpf   "  style="width: 220px;" type="text" name="titular_cpf" placeholder="DIGITE O CPF DO TITULAR" >
                            <input  required  class="form-control to-uppercase   "  style="width: 320px;" type="text" name="dependente_nome" placeholder="DIGITE O NOME  DO DEPENDENTE" >
                        
                        
                        </legend>

                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn btn-success" value="Gerar Formulário" name="SendPostForm" />
                        </div>
                        <!--BOTOES-->
                    </form>

                </div>



            </article>
        </div>




    </body>



</html>
