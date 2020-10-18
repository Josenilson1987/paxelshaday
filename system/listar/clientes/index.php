<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

//FILTRA O ID DO CLIENTE PASSADO NA URL ATRAVÉS DO METODO GET
$clientes_id = filter_input(INPUT_GET, 'clientes_id', FILTER_VALIDATE_INT);


//REALIZA UMA CONSULTA NA TABELA CLIENTES ATRAVÉS DO ID RECEBIDO NA VARIÁVEL $CLIENTES_ID
$read = new Read;
$read->ExeRead("clientes", "WHERE clientes_id = :id", "id={$clientes_id}");


if (!$read->getResult()):

else:

    foreach ($read->getResult() as $resultado):

    endforeach;

    require('_models/AdminClientes.class.php');
    $atualizar = new AdminClientes;
    $atualizar->Exelixeira($clientes_id, $resultado);
    header('Location:   painel.php?exe=listar/clientes/index&index');




endif;
?>


<!DOCTYPE html>
<html lang="pt-br">

    <head>



        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="css/listar_clientes.css">

        <link href="../../../css/listar_clientes.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>



        <table class="table table-striped">

            <thead>

            <th>NOME:</th>
            <th>CPF:</th>
            <th >CONTRATO:</th>
            <th>PEDIDO_ISCRIÇÃO:</th>
            <th>FICHA DE PAGAMENTO:</th>
            <th>ATUALIZAR:</th>
            <th>DELETAR:</th>




        </thead>

        <?php
        $listarclientes = new Read;
        $listarclientes->ExeRead("clientes", "WHERE lixeira = '0' ORDER BY titular_nome ");


        if (!$listarclientes->getResult()):

        else:

            foreach ($listarclientes->getResult() as $listarclientes):
                ?>                
                <tr class="to-uppercase">

                    <td><?= $listarclientes["titular_nome"]; ?></td>
                    <td><?= $listarclientes["cpf_titular"]; ?></td>
                    <td> <a class="btn  btn-success" href="painel.php?exe=contrato/A4/index&A4/index=&cpf_titular=<?= $listarclientes["cpf_titular"] ?> " name="contrato"> Contrato</a></td>
                    <td> <a class="btn  btn-primary" href="painel.php?exe=pedido_de_inscricao/A4/index&A4/index=&cpf_titular=<?= $listarclientes["cpf_titular"] ?> " name="pinscricao"> Pedido Inscrição</a></td>
                    <td> <a class="btn  btn-dark" href="painel.php?exe=ficha_de_pagamento/listar&listar/&cpf_titular=<?= $listarclientes["cpf_titular"] ?> " name="fpagamento"> Ficha de pagamento</a></td>
                    <td> <a class="btn  btn-danger" href="painel.php?exe=listar/clientes/index&index&clientes_id=<?= $listarclientes["clientes_id"] ?> " name="deletar"  onclick="return  confirm('Deseja mesmo deletar o cadastro ?');">Deletar</a></td>
                    <td> <a class="btn  btn-info" href="painel.php?exe=clientes/update&update&clientes_id=<?= $listarclientes["clientes_id"] ?> " name="atualizar">Atualizar</a></td>

                </tr> 

                <?php
            endforeach;
        endif;
        ?>
    </table>



</body>

</html>