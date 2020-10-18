<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


?>
<!DOCTYPE html>


<head>

    <title>CADASTRO DE CLIENTE</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/cadastrar_clientes.css">



</head>

<table class="table table-striped">

    <thead>

    <th>Nome:</th>

    <th>Nº Contrato:</th>

    <th>CPF:</th>
    <th>rRG:</th>
    <th>TELEFONE:</th>
    <th>Editar</th>
    <th>Excluir</th>

</thead>

<?php
$listarclientes = new Read;
$listarclientes->ExeRead("clientes");

if (!$listarclientes->getResult()):

else:

    foreach ($listarclientes->getResult() as $listarclientes):
        ?>                
        <tr class="to-uppercase">

            <td><?= $listarclientes["nome"]; ?></td>
            <td><?= $listarclientes["n_contrato"]; ?></td>
            <td><?= $listarclientes["cpf"]; ?></td>
            <td><?= $listarclientes["rg"]; ?></td>
            <td><?= $listarclientes["telefone"]; ?></td>

            <td><a href="painel.php?exe=clientes/update&cliente_id=<?= $listarclientes["clientes_id"]; ?>"  class="btn btn-info" >Editar</a></td>
            <td><a href="create.php?exe=jornada/create&delete=<?= $listarclientes["clientes_id"]; ?>" onclick="return confirm('Confirmar exclusão de registro?');"class="btn btn-danger">Excluir</a></td>
        </tr> 

        <?php
    endforeach;
endif;
?>
        

</table>




