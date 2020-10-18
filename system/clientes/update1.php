<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];

$clientes_id = filter_input(INPUT_GET, 'clientes_id', FILTER_VALIDATE_INT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


//var_dump($data);
if (!empty($data['SendPostForm'])):
    $data['lixeira'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1' );
    $data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿
  
    unset($data['SendPostForm']);

var_dump($data);

    require('_models/AdminClientes.class.php');
    $cadastra = new AdminClientes;
    $cadastra->ExeUpdate($clientes_id, $data);

    header("refresh: 5;painel.php");

    WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
else:
    $read = new Read;
    $read->ExeRead("clientes", "WHERE clientes_id = :id", "id={$clientes_id}");
    if (!$read->getResult()):
    //header('Location: painel.php');
    else:
        $data = $read->getResult()[0];
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
    
   
     
      
        <script>
            //FUNÇÃO ABAIXO ESTA  ATIVA NO INPUT N_CONTRATO A MESMA SERVE PARA IMPEDIR QUE SEJA INSERIDO 
            // TEXTOS NO INPUT PERMITINDO SOMENTE NUMEROS 
            function somenteNumeros(num) {
                var er = /[^0-9.]/;
                er.lastIndex = 0;
                var campo = num;
                if (er.test(campo.value)) {
                    campo.value = "";
                }
            }
        </script>

    </head>

    <body>
        <h3 style="text-align: center">Dados do Cliente</h3>

        <form class="uppercase" name="Formcliente" action="" method="post" id="Formcliente" >

            <input type="hidden" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj'] ?>' />
            <input type="hidden" name="lixeira" id="lixeira" value='<?= $data['lixeira'] ?>' />
            <input type="hidden" name="clientes_id"  id="clientes_id" value='<?= $data['clientes_id'] ?>' />
            <input type="hidden" name="cpf_titular"  value="<?php if (isset($data)) echo $data['cpf_titular']; ?>">

            

        <div class="content form_create">
            <article>

            <div class="well well-lg Form_cliente form-inline content form_create " >
            <label>Nome:</label>
            <input  required class="form-control to-uppercase"  style="width: 360px;" type="text" name="titular_nome" placeholder="Nome Do cliente" value="<?php if (isset($data)) echo $data['titular_nome']; ?>" >
        </div> <br>

        <div class="  form-inline" >

            <div class="form-group">
                <label>Ano de inscrição:</label>
                <input required class="form-control"   style="width: 150px;" type="text" name="ano_inscricao" placeholder="Ano da inscrição" maxlength="4" value="<?php if (isset($data)) echo $data['ano_inscricao']; ?>" onkeyup="somenteNumeros(this);">
            </div>
            <div class="form-group">

            </div>
            <div class="form-group">
                <label>Rg:</label>
                <input  required class="form-control to-uppercase rg "  style="width: 160px;" type="text" name="rg" placeholder="RG" maxlength="11" value="<?php if (isset($data)) echo $data['rg']; ?>" onkeyup="somenteNumeros(this);">

            </div>
            <div class="form-group">
                <label>Estado Civil:</label>
                <select class="form-control" name="estado_civil" >
                    <?php
                    $ReadSes = new Read;
                    $ReadSes->ExeRead("estado_civil");

                    if (!$ReadSes->getResult()):

                    else:
                        foreach ($ReadSes->getResult() as $ses):
                            echo" <option value=\"{$ses['estado_civil']}\" ";

                            if ($ses['estado_civil'] == $data['estado_civil']):
                                echo ' selected="selected" ';
                            endif;

                            echo "> {$ses['estado_civil']} </option>";
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label>Naturalidade:</label>
                <input  required class="form-control to-uppercase"  style="width: 160px;" type="text" name="naturalidade" placeholder="NATURALIDADE:"  value="<?php if (isset($data)) echo $data['naturalidade']; ?>">

            </div>


        </div>

        <br>

        <div class="form-inline">
            <div class="form-group">
                <label>Endereço:</label>
                <input  required class="form-control to-uppercase"  style="width: 370px;" type="text" name="endereco" placeholder="Endereço" value="<?php if (isset($data)) echo $data['endereco']; ?>">

            </div>
            <div class="form-group">
                <label>Número:</label>
                <input  required class="form-control to-uppercase"  style="width: 150px;" type="text" name="n_endereco" placeholder="Número"  value="<?php if (isset($data)) echo $data['n_endereco']; ?>" onkeyup="somenteNumeros(this);">

            </div>
            <div class="form-group">
                <label>Bairro:</label>
                <input  required class="form-control to-uppercase"  style="width: 190px;" type="text" name="bairro" placeholder="Bairro:"  value="<?php if (isset($data)) echo $data['bairro']; ?>">
                    
                </div>  
                
                
        </div>

        <br>

        <div class="form-inline">

        <div class="form-group">
                <label>Cep:</label>
                <input  required class="form-control to-uppercase cep"  style="width: 120px;" type="text" name="cep"  placeholder="Cep:" maxlength="8" value="<?php if (isset($data)) echo $data['cep']; ?>" onkeyup="somenteNumeros(this);">
            </div>

            <div class="form-group">
                <span class="">Estado:</span>
                <select class="j_loadstate form-control" name="estado">
                    <option value="" selected> Selecione o estado </option>
                    <?php
                    $readState = new Read;
                    $readState->ExeRead("app_estados", "ORDER BY estado_nome ASC");
                    foreach ($readState->getResult() as $estado):
                        extract($estado);
                        echo "<option value=\"{$estado_id}\" ";
                        if (isset($data['estado']) && $data['estado'] == $estado_id): echo 'selected';
                        endif;
                        echo "> {$estado_uf} / {$estado_nome} </option>";
                    endforeach;
                    ?>                        
                </select>

                <span class="">CIDADE:</span>
                <select class="j_loadcity form-control" name="cidade">
                    <?php if (!isset($data['cidade'])): ?>
                        <option value="" selected disabled> Selecione antes um estado </option>
                        <?php
                    else:
                        $City = new Read;
                        $City->ExeRead("app_cidades", "WHERE estado_id = :uf ORDER BY cidade_nome ASC", "uf={$data['estado']}");
                        if ($City->getRowCount()):
                            foreach ($City->getResult() as $cidade):
                                extract($cidade);
                                echo "<option value=\"{$cidade_id}\" ";
                                if (isset($data['cidade']) && $data['cidade'] == $cidade_id):
                                    echo "selected";
                                endif;
                                echo "> {$cidade_nome} </option>";
                            endforeach;
                        endif;
                    endif;
                    ?>
                </select>
            </div> 

            <div class="form-group">
                <label>Telefone:</label>
                <input  required class="form-control to-uppercase tel"  style="width: 145px;" type="text" name="telefone" placeholder="TELEFONE:" onkeypress="mascaratelefone(this, event)" value="<?php if (isset($data)) echo $data['telefone']; ?>">

            </div> 
           
        </div>
         <br>           
        <div class="form-inline">
                <label>Data de Nascimento:</label>
                <input  required class="form-control to-uppercase"  style="width: 180px;" type="date" name="data_de_nascimento" value="<?php if (isset($data)) echo $data['data_de_nascimento']; ?>">
                
            <span class="">NOME DO PAI:</span>
            <input  required class="form-control to-uppercase"  style="width: 200px;" type="text" name="nome_do_pai" placeholder="Nome do Pai" value="<?php if (isset($data)) echo $data['nome_do_pai']; ?>">
                    

            <span class="">PAI VIVO ?:</span>
            <select  required name="pai_vivo_falecido" class="form-control to-uppercase" value="">
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("sim_ou_nao");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['sim_ou_nao']}\" ";

                        if ($ses['sim_ou_nao'] == $data['pai_vivo_falecido']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['sim_ou_nao']} </option>";
                    endforeach;
                endif;
                ?>
            </select>
            <legend></legend>
            <span class="">NOME DA MÃE:</span>
            <input  required class="form-control to-uppercase"  style="width: 230px;" type="text" name="nome_da_mae" placeholder="Nome da mãe" value="<?php if (isset($data)) echo $data['nome_da_mae']; ?>">

            <span class="">VIVA ? </span>
            <select  required name="mae_viva_falecida" class="form-control to-uppercase" value="">
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("sim_ou_nao");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['sim_ou_nao']}\" ";

                        if ($ses['sim_ou_nao'] == $data['pai_vivo_falecido']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['sim_ou_nao']} </option>";
                    endforeach;
                endif;
                ?>
            </select>

            <span class="">PROFISSÃO:</span>
            <input  required class="form-control to-uppercase"  style="width: 250px;" type="text" name="profissao" placeholder="PROFISSÃO" value="<?php if (isset($data)) echo $data['profissao']; ?>">

            <span class="">RELIGIÃO:</span>
            <select  required name="religiao" class="form-control to-uppercase" value="" style="width: 190px;" >

                <option value=""> escolha a religião </option>
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("religioes");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['religioes']}\" ";

                        if ($ses['religioes'] == $data['religiao']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['religioes']} </option>";
                    endforeach;
                endif;
                ?>
            </select>
            <legend></legend>
            <span class="">NACIONALIDADE:</span>
            <input  required class="form-control to-uppercase"  style="width: 180px;" type="text" name="nacionalidade" placeholder="NACIONALIDADE" value="<?php if (isset($data)) echo $data['nacionalidade']; ?>">

            <span class="">TIPO DE PLANO:</span>
            <select  required name="tipo_de_plano" class="form-control to-uppercase" style="width: 150px;"  value="">
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("tipo_de_plano");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['tipo_de_plano']}\" ";

                        if ($ses['tipo_de_plano'] == $data['tipo_de_plano']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['tipo_de_plano']} </option>";
                    endforeach;
                endif;
                ?>
            </select>


            <span class="" >VALOR DO PLANO:</span>
            <select  required name="valor_do_plano" class="form-control to-uppercase" value="">


                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("valor_do_plano");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['valor_do_plano']}\" ";

                        if ($ses['valor_do_plano'] == $data['valor_do_plano']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['valor_do_plano']} </option>";
                    endforeach;
                endif;
                ?>
            </select>

            <label>Data do primeiro Pagamento</label>
            <input  required class="form-control to-uppercase"  style="width: 200px;" type="date" name="data_primeiro_pagamento" value="<?php if (isset($data)) echo $data['data_primeiro_pagamento']; ?>">
            <label>Nº da primeira parcela</label>
            <input  required class="form-control to-uppercase"  style="width: 50px;" type="text" name="n_parcela" value="<?php if (isset($data)) echo $data['n_parcela']; ?>" onkeyup="somenteNumeros(this);">
            <br>
            <br>  <br>
            <legend>Marque os Itens que acompanham o funeral para este cliente</legend>
            <br>  <br>
            <span class="">TIPO DE URNA:</span>
            <select  required name="tipo_de_urna" class="form-control to-uppercase" value="">

                <option value=""> tipo_de_urna </option>
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("tipo_de_urna");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['tipo_de_urna']}\" ";

                        if ($ses['tipo_de_urna'] == $data['tipo_de_urna']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['tipo_de_urna']} </option>";
                    endforeach;
                endif;
                ?>
            </select>

            <span class="">MODELO DE URNA:</span>
            <select  required name="modelo_de_urna" class="form-control to-uppercase" value="">

                <option value=""> tipo_de_urna </option>
                <?php
                $ReadSes = new Read;
                $ReadSes->ExeRead("modelo_de_urna");

                if (!$ReadSes->getResult()):

                else:
                    foreach ($ReadSes->getResult() as $ses):
                        echo" <option value=\"{$ses['modelo_de_urna']}\" ";

                        if ($ses['modelo_de_urna'] == $data['modelo_de_urna']):
                            echo ' selected="selected" ';
                        endif;

                        echo "> {$ses['modelo_de_urna']} </option>";
                    endforeach;
                endif;
                ?>
            </select>

            </div> 
       

            <!--BOTOES-->
            <div id="botoes">
                <a class="btn  btn-primary"href="painel.php?exe=clientes/index">Voltar</a>  
                <input type="submit" class="btn btn-warning" value="Atualizar" name="SendPostForm" />
                <input type="submit" class="btn btn-danger" value="Deletar" name="SendPostForm"  onclick="return  confirm('Deseja mesmo deletar o cadastro ?');"/>
                <a class="btn  btn-success"href="painel.php?exe=ficha_de_pagamento/listar&listar=&cpf_titular=<?= $data["cpf_titular"] ?>&nome_titular=<?= $data["titular_nome"] ?>">Gerar Ficha</a>  
            </div>
            <!--BOTOES-->

            <br>
            <br>
               <legend> Abaixo os pendentes do Cliente <?= $data['titular_nome']; ?></legend>

            <table class="table table-striped">

                <thead>

                <th>Nome:</th>
                <th>Data  Nascimento:</th>
                <th>Grau De Parentesco:</th>
                <th>Editar</th>


                </thead>

                <?php
// REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR
                extract($data);
                $cpf_titular = $data["cpf_titular"];

                $listardependentes = new Read;

                $listardependentes->ExeRead("dependentes", "WHERE cpf_titular='$cpf_titular'");



                if (!$listardependentes->getResult()):
                    WSErro("Não exite dependentes cadastrados com este titular ", WS_INFOR);
                else:

                    foreach ($listardependentes->getResult() as $listardependentes):
                        ?>                
                        <tr class="to-uppercase">

                            <td><?= $listardependentes["dependentes_nome"]; ?></td>
                            <td><?= $listardependentes["data_nascimento"]; ?></td>
                            <td><?= $listardependentes["grau_de_parentesco"]; ?></td>

                            <td> <a class="btn  btn-danger" href="painel.php?exe=dependentes/update&update=&cpf_titular<?= $data["cpf_titular"] ?>&nome_titular=<?= $data["titular_nome"] ?>&dependentes_id=<?= $listardependentes["dependentes_id"] ?>&dependentes_nome=<?= $listardependentes["dependentes_nome"] ?>" name="editar"> editar_dep</a></td>


                        </tr> 

                        <?php
                    endforeach;
                endif;
                ?>


            </table>
        </form>


    </body>

</html>
