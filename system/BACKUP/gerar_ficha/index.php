<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["cpf"] = str_replace([".", "-"], "", $data["cpf"]); // 00000000000﻿



if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

// REALIZA UMA CONSULTA NA TABELA CLIENTES E RETORNO O CPF VALIDO
    $cpf = $data["cpf"];
    $cpf = $data["cpf"];
    $verificacpf = new Read;
    $verificacpf->ExeRead("clientes", "WHERE cpf='$cpf'");

    // REALIZA UMA CONSULTA NA TABELA FICHA DE PAMENTO E RETORNO O CPF VALIDO
    $cpf = $data["cpf"];
    $verifica_cpf_ficha = new Read;
    $verifica_cpf_ficha->ExeRead("ficha_pagamento", "WHERE cpf='$cpf'");

    if (count($verificacpf->getResult()) > 0):

         if ($verificacpf->getResult()[0]['lixeira'] > 0):
            WSErro("Já existe um cadastro com o cpf: <b>$cpf</b>  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro ", WS_INFOR);

        elseif (count($verifica_cpf_ficha->getResult()[0])):
            header('Location: painel.php?exe=gerar_ficha/listar&listar=true&cpf=' . $verifica_cpf_ficha->getResult()[0]['cpf']);
        else:
            header('Location: painel.php?exe=gerar_ficha/create&create=&titular_nome=' . $verificacpf->getResult()[0]['titular_nome']
                    . '&cpf=' . $verificacpf->getResult()[0]['cpf'] . '&n_contrato=' . $verificacpf->getResult()[0]['n_contrato'] . '&ano_inscricao=' . $verificacpf->getResult()[0]['ano_inscricao'] . '&ano_inscricao=' . $verificacpf->getResult()[0]['ano_inscricao']);
        endif;
    else:
        WSErro("O cpf : <b>$cpf</b>  Não está cadastrado como um cliente, Por favor cadastre o mesmo como cliente antes de gerar uma ficha", WS_INFOR);

      
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

        <link rel="stylesheet" type="text/css" href="css/cadastrar_clientes.css">

    </head>

    <body>

        <div class="content form_create">
            <article>

                <div class="well well-lg Form_cliente form-inline content form_create " >

                    <form class="uppercase" name="Formcliente" action="" method="post"  >

                        <input type="hidden" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj']; ?>' />

                        <legend>Para gerar uma ficha de pagamento informe o cpf do titular </legend>

                        <input  required class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf"  placeholder="cpf" maxlength="11" autofocus>



                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm" />

                        </div>
                        <!--BOTOES-->
                    </form>

                </div>

            </article>
        </div>



    </body>



</html>
