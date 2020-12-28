<?php
    

if (!class_exists('Login')) :
    header('Location: ../painel.php');
   die;
endif;



$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿






if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    $cpf_titular = $data["cpf_titular"];
    $verificacpf = new Read;
    $verificacpf->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");


    if (count($verificacpf->getResult()) > 0):
        
        
        if ($verificacpf->getResult()[0]['lixeira'] > 0):
            WSErro("Já existe um cadastro com o cpf: <b>$cpf</b>  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro ", WS_INFOR);
        else:
          
           header('Location: painel.php?exe=contrato/A4/index&index=true&cpf_titular=' . $verificacpf->getResult()[0]['cpf_titular']);
        endif;
    else:
//        header('Location: painel.php?exe=clientes/create&create=true&cpf=' . $data["cpf"]);
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
               <legend style="text-align: center; color: blue;">Informe o cpf do titular para gerar o contrato:</legend>
                <div class="well well-lg Form_cliente form-inline content form_create " >

                    <form class="uppercase" name="Formcliente" action="" method="post"  >

                        <input  required class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular"  placeholder="cpf_titular" maxlength="11">

                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn btn-dark" value="Consultar" name="SendPostForm" />
                        </div>
                        <!--BOTOES-->
                    </form>

                </div>
            </article>
        </div>

</body>

</html>