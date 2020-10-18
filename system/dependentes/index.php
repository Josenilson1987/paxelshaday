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

$data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿
$data["cpf_dep"] = str_replace([".", "-"], "", $data["cpf_dep"]); // 00000000000﻿


// REALIZA UMA CONSULTA NA TABELA TITULAR E RETORNO ATRAVÉS DO CPF O NOME DO TITULAR
$cpf_titular = $data["cpf_titular"];
$verifica_cpf_titular = new Read;
$verifica_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");


// REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF VALIDO
$cpf_dep = $data["cpf_dep"];
$verifica_cpf_dep = new Read;
$verifica_cpf_dep->ExeRead("dependentes", "WHERE cpf_dep='$cpf_dep'");

//VERIFICA SE O CPF DO DEPENDENTE INFORMADO JÁ EXISTE COMO TITULAR .
$valida_cpf_titular = new Read;
$valida_cpf_titular->ExeRead("clientes", "WHERE cpf_titular='$cpf_dep'");


    
if (count($verifica_cpf_titular->getResult()) === 0):
 WSErro("O CPF  <b>Titular</b> informado não é valido, por favor informe um CPF valido .", WS_INFOR);   
 else:
  
if ($verifica_cpf_titular->getResult()[0]['lixeira'] > 0):
WSErro("Já existe um cadastro com o CPF: <b>Titular</b> informado,  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro . ", WS_INFOR);

elseif ($data["cpf_titular"] === $data["cpf_dep"]):
WSErro("O CPF do <b>Dependente</b> não pode ser igual ao do <b>Titular</b>, Por favor informe um CPF <b>Dependente</b> diferente", WS_INFOR);

elseif (count($verifica_cpf_dep->getResult()) > 0):

if ($verifica_cpf_dep->getResult()[0]['lixeira'] > 0):
WSErro("Já existe um cadastro com o cpf <b>Dependente</b> informado,  porem o mesmo foi excluido, solicite ao administrador do sistema para restaurar o cadastro . ", WS_INFOR);
else:
header('Location: painel.php?exe=dependentes/update&update=true&dependentes_id=' . $verifica_cpf_dep->getResult()[0]['dependentes_id']);
endif;
else:
header('Location: painel.php?exe=dependentes/create&create=&cpf_titular=' . $data['cpf_titular'] .'&titular_nome=' . $verifica_cpf_titular->getResult()[0]['titular_nome']. '&cpf_dep=' . $data['cpf_dep'] .'&nome_dep='.$valida_cpf_titular->getResult()[0]['titular_nome']);
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


                            <input  required class="form-control to-uppercase cpf   "  style="width: 220px;" type="text" name="cpf_titular" placeholder="DIGITE O CPF DO TITULAR" >
                            <input  required  class="form-control to-uppercase cpf   "  style="width: 250px;" type="text" name="cpf_dep" placeholder="DIGITE O CPF DO DEPENDENTE" >
                        
                        
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
