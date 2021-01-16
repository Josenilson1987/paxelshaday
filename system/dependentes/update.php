<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];


$dependentes_id = filter_input(INPUT_GET, 'dependentes_id', FILTER_VALIDATE_INT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($data['SendPostForm'])) :
    $data['dependente_lixeira'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1');
    $data["titular_cpf"] = str_replace([".", "-"], "", $data["titular_cpf"]); // 00000000000﻿
    $data["dependente_cpf"] = str_replace([".", "-"], "", $data["dependente_cpf"]); // 00000000000﻿
    unset($data['SendPostForm']);

    require('_models/AdminDependentes.class.php');
    $cadastra = new AdminDependentes;
    $cadastra->ExeUpdate($dependentes_id, $data);

    header("refresh: 5;painel.php");

    WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
else :
    $read = new Read;
    $read->ExeRead("dependentes", "WHERE dependentes_id = :id", "id={$dependentes_id}");
    if (!$read->getResult()) :

    //     header('Location: painel.php');
    else :
        $data = $read->getResult()[0];

    endif;
endif;



// REALIZA UMA CONSULTA NA TABELA TITULAR E RETORNO ATRAVÉS DO CPF O NOME DO TITULAR
$cpf_titular = $data["titular_cpf"];
$verifica_cpf_titular = new Read;
$verifica_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");
foreach ($verifica_cpf_titular->getResult() as $NomeTitular) :
//echo $NomeTitular["titular_nome"];
endforeach;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body>
    <div class="content form_create">
    
                <form class="uppercase" name="Formcliente" action="" method="post" id="Formcliente">

                    
                    <input type="hidden" name="dependente_lixeira" id="dependente_lixeira" value='<?= $data['lixeira'] ?>' />
                    <input type="hidden" name="dependentes_id" id="dependentes_id" value='<?= $data['dependentes_id'] ?>' />

                    <h2> Atualizar Dependente </h2>
                    <br>

                    <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">CPF TITULAR:</span>
                        <input required class="form-control to-uppercase cpf   " style="width: 140px; display:disnable"
                         type="text" name="titular_cpf" value="<?php if (isset($data)) {echo $data['titular_cpf'];} ?>">
                         <span class="input-group-text to-uppercase" id="basic-addon3">NOME DO TITULAR:-  <b> <?= $NomeTitular["titular_nome"]; ?><b></span>
                      
                    </div>
                    <br>
                    <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">NOME DO DEPENDENTE:</span>
                        <input required class="form-control to-uppercase" style="width: 360px;" type="text" 
                    name="dependente_nome" value="<?php if (isset($data)) { echo $data['dependente_nome']; }  ?>">
                    </div>
                    <br>

                    <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">CPF DO DEPENDENTE:</span>
                        <input required class="form-control to-uppercase cpf" style="width: 360px;" type="text" 
                    name="dependente_cpf" value="<?php if (isset($data)) { echo $data['dependente_cpf']; }  ?>">
                    </div>
                    <br>


                    <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">RG DO DEPENDENTE:</span>
                        <input required class="form-control to-uppercase" style="width: 360px;" type="text" 
                    name="dependente_rg" value="<?php if (isset($data)) { echo $data['dependente_rg']; }  ?>">
                    </div>
                    <br>
                

                    <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">DATA DE NASCIMENTO:</span>
                        <input class="form-control to-uppercase" style="width: 180px;" 
                        type="date" name="dependente_data_nascimento" value="<?php if (isset($data)) { echo $data['dependente_data_nascimento'];}?>">
                    
                        <div class="input-group-prepend  ">
                        <span class="input-group-text" id="basic-addon3">PARENTESCO:</span>
                        <select class="form-control" name="dependente_grau_de_parentesco">
                        <?php
                        $ReadSes = new Read;
                        $ReadSes->ExeRead("grau_de_parentesco");

                        if (!$ReadSes->getResult()) :

                        else :
                            foreach ($ReadSes->getResult() as $ses) :
                                echo " <option value=\"{$ses['grau_de_parentesco']}\" ";

                                if ($ses['grau_de_parentesco'] == $data['dependente_grau_de_parentesco']) :
                                    echo ' selected="selected" ';
                                endif;

                                echo "> {$ses['grau_de_parentesco']} </option>";
                            endforeach;
                        endif;
                        ?>
                    </select>

                    </div>

                    </div>
             
                    <br>
                                                                                                       
                    <!--BOTOES-->
                    <div id="botoes">
                       
                        <a class="btn  btn-primary" href="javascript:window.history.go(-1)">Voltar a pagina anterior</a>

                        <input type="submit" class="btn btn-warning" value="Atualizar" name="SendPostForm" />
                        <input type="submit" class="btn btn-danger" value="Deletar" name="SendPostForm" onclick="return  confirm('Deseja mesmo deletar o cadastro ?');" />
                        <a class="btn  btn-success" href="painel.php?exe=dependentes/index">Novo Dependente</a>
                    </div>
                    <!--BOTOES-->
                </form>

          

    </div>

</body>

</html>