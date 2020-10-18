

<?php
if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cpf_titular = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);
$titular = filter_input(INPUT_GET, 'titular_nome', FILTER_SANITIZE_STRING);

$cpf_dep = filter_input(INPUT_GET, 'cpf_dep', FILTER_DEFAULT);
$nome_dep = filter_input(INPUT_GET, 'nome_dep', FILTER_DEFAULT);

$lixeira = 0;
$data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿

?>



<?php
if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    $data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿
    $data["cpf_dep"] = str_replace([".", "-"], "", $data["cpf_dep"]); // 00000000000﻿

    // REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF VALIDO
    $cpf_dep = $data["cpf_dep"];
    $verifica_cpf_dep = new Read;
    $verifica_cpf_dep->ExeRead("dependentes", "WHERE cpf_dep='$cpf_dep'");

    $valida_cpf_titular = new Read;
    $valida_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$cpf_dep'");
//-------------------------------------------------------------------------




    if (count($verifica_cpf_dep->getResult()) > 0):

        if ($verifica_cpf_dep->getResult()[0]['lixeira'] > 0):
            WSErro("Já existe um cadastro com o cpf <b>Dependente</b> informado,  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro . ", WS_INFOR);
        else:
            header('Location: painel.php?exe=dependentes/update&update=true&dependentes_id=' . $verifica_cpf_dep->getResult()[0]['dependentes_id']);
        endif;
    else:
        require '_models/AdminDependentes.class.php';
        $cadastra = new AdminDependentes;
        $cadastra->ExeCreate($data);
        WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);
       header("refresh: 5;painel.php?exe=dependentes/index");
        if (!$cadastra->getResult()):
            WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
        else:

        endif;
    endif;


endif;
?>


<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <title>CADASTRO DE DEPENDENTES</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/cadastrar_dependentes.css">



    </head>

    <body >

        <div class=" form_create">
            <article>

                <div class="well well-lg  form-inline " >
                    <form class="to-uppercase" name="Formcliente" action="" method="post" >

                        <label>Cadastrar  Dependentes</label>
                        <br>    
                        <b>Cpf do titular:</b>
                        <input   class="form-control to-uppercase cpf   "  style="width: 140px; display:disnable" type="text" name="cpf_titular" value="<?php if (isset($cpf_titular)) echo $cpf_titular ?>"  readonly="true">
                        <input   class="form-control "  style="width: 120px; display:none" type="text" name="lixeira" value="<?php if (isset($lixeira)) echo $lixeira ?>" >

                        <b>Nome do Titular: <?php if (isset($cpf_titular)) echo $titular ?></b>
                        -
                        <b>Cpf do Dependente:</b>

                        <?php if (isset($cpf_dep)) { ?>  

                            <input  required class="form-control to-uppercase cpf   "  style="width: 150px; display:disnable" type="text" name="cpf_dep" value="<?php if (isset($cpf_dep)) echo $cpf_dep ?>" readonly >

                        <?php } else { ?>
                            <input  required class="form-control to-uppercase cpf   "  style="width: 150px; display:disnable" type="text" name="cpf_dep" value="<?php if (isset($cpf_dep)) echo $cpf_dep ?>"   >
                        <?php } ?>



                        <legend></legend>

                        <?php if ($nome_dep != '') { ?>  

                            <input  required class="form-group to-uppercase"  style="width: 270px;" type="text" name="dependentes_nome"  placeholder="DIGITE O NOME DO DEPENDENTE" value="<?php if (isset($nome_dep)) echo $nome_dep ?>" readonly>

                        <?php } else { ?>
                           
                                <input  required class="form-control to-uppercase"  style="width: 270px;" type="text" name="dependentes_nome"  placeholder="DIGITE O NOME DO DEPENDENTE" value="<?php if (isset($nome_dep)) echo $nome_dep ?>" autofocus="">
                           
                        <?php } ?>

                            
                        <input   class="form-control  rg "  style="width: 120px;" type="text" name="rg" placeholder="DIGITE O RG:" >                       
                       
                       

                        <input   class="form-control to-uppercase"  style="width: 190px;" type="date" name="data_nascimento">

                        <select  required name="grau_de_parentesco" class="form-control" value="">
                            <option  value="" selected="selected">GRAÚ DE PARENTESCO</option>
                            <option value="ESPOSO" >ESPOSO</option>
                            <option value="ESPOSA" >ESPOSA</option>
                            <option value="FILHO">FILHO</option>
                            <option value="FILHA">FILHA</option>
                            <option value="TIO">TIO</option>                        
                            <option value="TIA">TIA</option> 
                            <option value="SOBRINHO">SOBRINHO</option>                        
                            <option value="SOBRINHA">SOBRINHA</option> 
                            <option value="AVÔ">AVÔ</option> 
                            <option value="AVÓ">AVÓ</option>                        
                            <option value="PRIMO">PRIMO</option>
                            <option value="PRIMA">PRIMA</option>

                        </select>
                        <br><br>
                        <a class="btn  btn-primary"href="painel.php?exe=dependentes/index">Alterar CPF</a>  
                        <a class="btn  btn-danger"href="painel.php">Cancelar</a>  
                        <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm"/>

                    </form>
                </div>
            </article>

        </div>









    </body>



</html>
