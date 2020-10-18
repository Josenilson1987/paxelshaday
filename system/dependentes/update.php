<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];


$dependentes_id = filter_input(INPUT_GET, 'dependentes_id', FILTER_VALIDATE_INT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (!empty($data['SendPostForm'])):
    $data['lixeira'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1' );
    $data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿
    $data["cpf_dep"] = str_replace([".", "-"], "", $data["cpf_dep"]); // 00000000000﻿
    unset($data['SendPostForm']);

    require('_models/AdminDependentes.class.php');
    $cadastra = new AdminDependentes;
    $cadastra->ExeUpdate($dependentes_id, $data);

    header("refresh: 5;painel.php");

    WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
else:
    $read = new Read;
    $read->ExeRead("dependentes", "WHERE dependentes_id = :id", "id={$dependentes_id}");
    if (!$read->getResult()):
//     header('Location: painel.php');
    else:
        $data = $read->getResult()[0];
    endif;
endif;



// REALIZA UMA CONSULTA NA TABELA TITULAR E RETORNO ATRAVÉS DO CPF O NOME DO TITULAR
$cpf_titular = $data["cpf_titular"];
$verifica_cpf_titular = new Read;
$verifica_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");
foreach ($verifica_cpf_titular->getResult() as $NomeTitular):
//    echo $NomeTitular["nome"];
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
            <article>

                <div class="well form-inline  " >

                    <form class="uppercase" name="Formcliente" action="" method="post" id="Formcliente" >

                        <input type="hidden" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj'] ?>' />
                        <input type="hidden" name="lixeira" id="lixeira" value='<?= $data['lixeira'] ?>' />
                        <input type="hidden" name="dependentes_id"  id="dependentes_id" value='<?= $data['dependentes_id'] ?>' />

                        <label>Atualizar Dependente</label>
                        <br>    
                        <b>CPF/TITULAR:</b>
                        <input  required class="form-control to-uppercase cpf   "  style="width: 140px; display:disnable" type="text" name="cpf_titular" value="<?phP if (isset($data)) {echo $data['cpf_titular'];}
                        ?>" >

                        <b class="to-uppercase">NOME/TITULAR: <?= $NomeTitular["titular_nome"]; ?></b>
                         <br>
                        <b>CPF DO DEPENDENTE:</b>
                        <input  required class="form-control to-uppercase cpf   "  style="width: 150px; display:disnable" type="text" name="cpf_dep" value="<?php if (isset($data)) { echo $data['cpf_dep'];}
                        ?>" readonly="true"  >
                        <legend></legend>

                        <span class="">Nome:</span>
                        <br>
                        <input  required class="form-control to-uppercase"  style="width: 260px;" type="text" name="dependentes_nome" value="<?php if (isset($data)) { echo $data['dependentes_nome'];}
                        ?>">
                        <span class="">RG:</span>
                        <input   class="form-control to-uppercase rg "  style="width: 120px;" type="text" name="rg" value="<?php if (isset($data)) {echo $data['rg'];}
                        ?>">                       

                        <label>Data Nascimento</label>
                        <input   class="form-control to-uppercase"  style="width: 180px;" type="date" name="data_nascimento"  value="<?php if (isset($data)) {echo $data['data_nascimento'];}
                        ?>">


                        <span class="">Parentesco:</span>
                        <select class="form-control" name="grau_de_parentesco" >
                            <?php
                            $ReadSes = new Read;
                            $ReadSes->ExeRead("grau_de_parentesco");

                            if (!$ReadSes->getResult()):

                            else:
                                foreach ($ReadSes->getResult() as $ses):
                                    echo" <option value=\"{$ses['grau_de_parentesco']}\" ";

                                    if ($ses['grau_de_parentesco'] == $data['grau_de_parentesco']):
                                        echo ' selected="selected" ';
                                    endif;

                                    echo "> {$ses['grau_de_parentesco']} </option>";
                                endforeach;
                            endif;
                            ?>
                        </select>


                       


                        <!--BOTOES-->
                        <div id="botoes">
                             <br>
                            <a class="btn  btn-primary"href="javascript:window.history.go(-1)">Voltar a pagina anterior</a>  
                            
                            <input type="submit" class="btn btn-warning" value="Atualizar" name="SendPostForm" />
                            <input type="submit" class="btn btn-danger" value="Deletar" name="SendPostForm"  onclick="return  confirm('Deseja mesmo deletar o cadastro ?');"/>
                             <a class="btn  btn-success"href="painel.php?exe=dependentes/index">Novo Dependente</a>  
                        </div>
                        <!--BOTOES-->
                    </form>

                </div>



            </article>
        </div>

    </body>

</html>
