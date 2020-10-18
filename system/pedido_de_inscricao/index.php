<?php
$userlogin = $_SESSION['empresa_cnpj'];

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
            header('Location: painel.php?exe=pedido_de_inscricao/A4/index&index=true&cpf_titular=' . $verificacpf->getResult()[0]['cpf_titular']);
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

                <div class="well well-lg Form_cliente form-inline content form_create " >

                    <form class="uppercase" name="Formcliente" action="" method="post"  >

                        <input  required class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular"  placeholder="cpf_titular" maxlength="11"  value="<?php if (isset($cpf_titular)) echo $cpf_titular ?>">

                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn btn-success" value="Consultar" name="SendPostForm" />
                        </div>
                        <!--BOTOES-->
                    </form>

                </div>



            </article>
        </div>

<!--        <table class="table table-striped">

            <thead>

            <th>Nome:</th>
            <th>CPF:</th>


        </thead>

<?php
extract($data);
$cpf = $data["cpf"];

$listarclientes = new Read;
$listarclientes->ExeRead("clientes", "WHERE cpf='$cpf'");

if (!$listarclientes->getResult()):

else:

    foreach ($listarclientes->getResult() as $listarclientes):
        ?>                
                <tr class="to-uppercase">

                    <td><?= $listarclientes["titular_nome"]; ?></td>

                    <td><?= $listarclientes["cpf"]; ?></td>

                </tr> 

        <?php
    endforeach;
endif;
?>
    </table>-->

      

</body>

</html>