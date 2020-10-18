<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿



if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    $cpf = $data["cpf_titular"];
    $verificacpf = new Read;
    $verificacpf->ExeRead("clientes", "WHERE cpf_titular='$cpf'");



    $cpf_dep = $data["cpf_titular"];
    $listardep = new Read;
    $listardep->ExeRead("dependentes", "WHERE cpf_dep='$cpf_dep'");

    if (count($listardep->getResult()) > 0 && count($verificacpf->getResult()) > 0):
        header('Location: painel.php?exe=clientes/update&update=true&clientes_id=' . $verificacpf->getResult()[0]['clientes_id']);
        else:
        header('Location: painel.php?exe=clientes/create&create=true&cpf_titular=' . $data["cpf_titular"] . '&nome_dep=' . $listardep->getResult()[0]['dependentes_nome']);

        if (count($verificacpf->getResult()) > 0):

                if ($verificacpf->getResult()[0]['lixeira'] > 0):
                    WSErro("Já existe um cadastro com o cpf: <b>$cpf</b>  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro ", WS_INFOR);
                else:
                    header('Location: painel.php?exe=clientes/update&update=true&clientes_id=' . $verificacpf->getResult()[0]['clientes_id']);
                endif;
            else:
 header('Location: painel.php?exe=clientes/create&create=true&cpf_titular=' . $data["cpf_titular"] . '&nome_dep=' . $listardep->getResult()[0]['dependentes_nome']);
            endif;
        endif;
  

endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <title>CADASTRO DE CLIENTE</title>

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

                        <legend>Para consultar ou cadastrar um cliente informe o CPF:</legend>

                        <input  required class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular"  placeholder="Digite o cpf " maxlength="11" autofocus>



                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn btn-success" value="Cadastrar / Consultar" name="SendPostForm" />

                        </div>
                        <!--BOTOES-->
                    </form>

                </div>

            </article>
        </div>



    </body>



</html>
