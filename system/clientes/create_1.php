<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];



$cpf = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);
$nome_dep = filter_input(INPUT_GET, 'nome_dep', FILTER_DEFAULT);

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿

$lixeira = 0;
$n_parcela = 1;
$contrato_cliente = " ";



$listardep = new Read;
$listardep->ExeRead("dependentes", "WHERE cpf_dep='$cpf'");



if (!empty($data['SendPostForm'])) :
    unset($data['SendPostForm']);

    if ($listardep->getResult()) :


        if (($listardep->getResult()[0]['dependentes_nome'] != $data['titular_nome'])) :
            WSErro("Este cpf já esta cadastrado como dependete, para cadastrar como titular não alterar o nome do titular", WS_ALERT);
        else :
            require '_models/AdminClientes.class.php';

            $cadastra = new AdminClientes;
            $cadastra->ExeCreate($data);


            WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);

            header("refresh: 5;painel.php?");
            if (!$cadastra->getResult()) :
                WSErro($cadastra->getError()[0], $cadastra->getError()[1]);

            else :

            endif;

        endif;

    else :
        require '_models/AdminClientes.class.php';

        $cadastra = new AdminClientes;
        $cadastra->ExeCreate($data);


        WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);
        header("refresh: 5;painel.php");
        if (!$cadastra->getResult()) :
            WSErro($cadastra->getError()[0], $cadastra->getError()[1]);

        else :

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




    <div class="content form_create">
        <article>

            <div class="well well-lg Form_cliente form-inline content form_create ">

                <form class="uppercase" name="Formcliente" action="" method="post">

                    <input type="text" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj']; ?>' style="display: none;" />
                    <input type="text" name="lixeira" value='<?= $lixeira; ?>' style="display: none;" />



                    <legend>Cadastrar Cliente


                    </legend>

                    <input required class="form-control to-uppercase cpf " style="width: 160px;" type="text" name="cpf_titular" id="cpf" placeholder="cpf" maxlength="11" value="<?php if (isset($cpf)) echo $cpf ?>" readonly>
                    <input required class="form-control" style="width: 140px;" type="int" name="ano_inscricao" placeholder="Ano da Inscrição" maxlength="4" autofocus onkeyup="somenteNumeros(this);">
                    <input required class="form-control to-uppercase" style="width: 353px;" type="text" name="titular_nome" placeholder="Nome Do cliente" value="<?php if (isset($nome_dep)) echo $nome_dep ?>">
                    <input required class="form-control to-uppercase rg " style="width: 150px;" type="text" name="rg" placeholder="RG" maxlength="11">

                    <select required name="estado_civil" class="form-control" value="">
                        <option value="" selected="selected">ESTADO CIVIL</option>
                        <option value="solteiro">SOLTEIRO</option>
                        <option value="solteira">SOLTEIRA</option>
                        <option value="casado">CASADO</option>
                        <option value="casada">CASADA</option>
                        <option value="divorciado">DIVORCIADO</option>
                        <option value="divorciada">DIVORCIADA</option>
                        <option value="conjugue">CONJUGUE</option>
                        <option value="viuvo">VIUVO</option>
                        <option value="viuva">VIUVA</option>


                    </select>

                    <input required class="form-control to-uppercase" style="width: 350px;" type="text" name="endereco" placeholder="Endereço">
                    <input required class="form-control to-uppercase" style="width: 150px;" type="text" name="n_endereco" placeholder="Número">
                    <input required class="form-control to-uppercase" style="width: 150px;" type="text" name="bairro" placeholder="Bairro:">
                    <input required class="form-control to-uppercase cep" style="width: 120px;" type="text" name="cep" placeholder="Cep:" maxlength="8">





                    <select class="j_loadstate form-control" name="estado">
                        <option value="" selected> Selecione o estado </option>
                        <?php
                        $readState = new Read;
                        $readState->ExeRead("app_estados", "ORDER BY estado_nome ASC");
                        foreach ($readState->getResult() as $estado) :
                            extract($estado);
                            echo "<option value=\"{$estado_id}\" ";
                            if (isset($data['empresa_uf']) && $data['empresa_uf'] == $estado_id) : echo 'selected';
                            endif;
                            echo "> {$estado_uf} / {$estado_nome} </option>";
                        endforeach;
                        ?>
                    </select>

                    <select class="j_loadcity form-control" name="cidade">
                        <?php if (!isset($data['cidade'])) : ?>
                            <option value="" selected disabled> Selecione antes um estado </option>
                        <?php
                        else :
                            $City = new Read;
                            $City->ExeRead("app_cidades", "WHERE estado_id = :uf ORDER BY cidade_nome ASC", "uf={$data['empresa_uf']}");
                            if ($City->getRowCount()) :
                                foreach ($City->getResult() as $cidade) :
                                    extract($cidade);
                                    echo "<option value=\"{$cidade_id}\" ";
                                    if (isset($data['empresa_cidade']) && $data['empresa_cidade'] == $cidade_id) :
                                        echo "selected";
                                    endif;
                                    echo "> {$cidade_nome} </option>";
                                endforeach;
                            endif;
                        endif;
                        ?>
                    </select>





                    <input required class="form-control to-uppercase" style="width: 200px;" type="text" name="naturalidade" placeholder="NATURALIDADE:" onkeypress="mascaratelefone(this, event)">
                    <input required class="form-control to-uppercase tel" style="width: 250px;" type="text" name="telefone" placeholder="TELEFONE:" onkeypress="mascaratelefone(this, event)">
                    <label>Data De Nascimento</label>
                    <input required class="form-control to-uppercase" style="width: 250px;" type="date" name="data_de_nascimento">

                    <input required class="form-control to-uppercase" style="width: 240px;" type="text" name="nome_do_pai" placeholder="Nome do Pai">
                    <select required name="pai_vivo_falecido" class="form-control">
                        <option value="" selected="selected"> SIM OU NÃO ?</option>
                        <option value="sim">SIM</option>
                        <option value="nao">NÃO</option>
                    </select>

                    <input required class="form-control to-uppercase" style="width: 220px;" type="text" name="nome_da_mae" placeholder="Nome da mãe">
                    <select required name="mae_viva_falecida" class="form-control">
                        <option value="" selected="selected">É VIVA SIM OU NÃO ?</option>
                        <option value="sim">SIM</option>
                        <option value="nao">NÃO</option>
                    </select>

                    <input required class="form-control to-uppercase" style="width: 200px;" type="text" name="profissao" placeholder="PROFISSÃO">


                    <select required name="religiao" class="form-control" value="">
                        <option value="" selected="selected">RELIGIÃO</option>
                        <option value="catolico">CATÓLICO</option>
                        <option value="protestante">PROTESTANTE</option>
                        <option value="crista">CRISTA</option>
                        <option value="tafricana">MATRIZ AFRICANA</option>
                        <option value="espirita">ESPIRITA</option>
                        <option value="tjeova">TESTEMINHAS DE JEOVA</option>
                    </select>

                    <input required class="form-control to-uppercase" style="width: 200px;" type="text" name="nacionalidade" placeholder="NACIONALIDADE">

                    <select required name="tipo_de_plano" class="form-control" value="">
                        <option value="" selected="selected">TIPO DE PLANO</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>


                    <select required name="valor_do_plano" class="form-control">
                        <option value="" selected="selected">VALOR DO PLANO</option>
                        <option value="40,00">R$ 40,00</option>
                        <option value="70,00">R$ 70,00</option>
                        <option value="90,00">R$ 90,00</option>
                    </select>

                    <label>Data do primeiro Pagamento</label>

                    <input required class="form-control to-uppercase" style="width: 200px;" type="date" name="data_primeiro_pagamento">

                    <label>Nº da primeira parcela</label>
                    <input required class="form-control to-uppercase" style="width:50px;" type="text" name="n_parcela" placeholder="Nº" onkeyup="somenteNumeros(this);" value="<?= $n_parcela ?>" readonly>
                    <br>
                    <br>
                    <legend>Marque os Itens que acompanham o funeral para este cliente</legend>

                    <select required name="tipo_de_urna" class="form-control">
                        <option value="" selected="selected">TIPO DE URNA</option>
                        <option value="parreira">PARREIRA</option>
                        <option value="varam">VARAM</option>
                        <option value="varamzinho">VARAMZINHO</option>
                        <option value="alcadura">ALÇA DURA</option>
                        <option value="alacaparreira">ALÇA PAREIRA</option>

                    </select>

                    <select required name="modelo_de_urna" id="modelo_de_urna" class="form-control">
                        <option value="" selected="selected">MODELO DE URNA</option>
                        <option value="com-visor">COM VISOR </option>
                        <option value="sem-visor">SEM VISOR </option>
                    </select>







                    <!--BOTOES-->
                    <div id="botoes">
                        <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm" id="SendPostForm" />

                    </div>
                    <!--BOTOES-->
                </form>

            </div>



        </article>
    </div>
</body>

</html>