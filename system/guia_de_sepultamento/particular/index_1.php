<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$taxa_juros = new Read;
$taxa_juros->ExeRead("taxa_juros");


$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


$idade = 0;


if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    //RESPONSÁVEL POR REMOVER OS CARACTERES ESPECIAIS DA FUNÇÃO MASCARA 
    $data["cpf_responsavel"] = str_replace([".", "-"], "", $data["cpf_responsavel"]); // 00000000000﻿
    $data["cpf_falecido"] = str_replace([".", "-"], "", $data["cpf_falecido"]); // 00000000000﻿
    // RESPONSABILIDADE DESSE IF SE DATA EXISTIR AS VARIAVEIS PASSAM COM OS VALORES DO FORMULARIO 
    // SE NÃO OS ATRIBUTOS PASSA COM O VALOR VAZIO EVITANDO O ERRO DE VARIÁVEL Undefined INDEFINIDA OU NÃO EXISTENTE
    if (isset($data)):

    else:

        $data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro'] = '';
        $data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao'] = '';
        $data['forma_de_pagamento_dinheiro_e_cartao_parcelas'] = '';
        $data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela'] = '';
        $data['forma_de_pagamento_dinheiro_e_cartao_bandeira'] = '';
        $data['forma_de_pagamento_dinheiro_e_cartao_numero'] = '';
    endif;



    $verifica_cpf_falecido = new Read;
    $verifica_cpf_falecido->ExeRead("guia_de_sepultamento", "WHERE cpf_falecido= {$data['cpf_falecido']}");

    if ($data['cpf_falecido'] === $data['cpf_responsavel']):
        WSErro("O CPF do <b>Falecido</b> não pode ser igual ao CPF do <b>Responsável</b> por favor altere o CPF do <b>Falecido</b>", WS_INFOR);
    elseif ($verifica_cpf_falecido->getResult()):
        WSErro("O  CPF: <b>{$data['cpf_falecido']}</b> Já contem uma guia gerada, Nome do falecido (a) <b class='to-uppercase'>{$verifica_cpf_falecido->getResult()[0]['nome_falecido']}</b>, favor informar outro CPF Numero da guia <b>{$verifica_cpf_falecido->getResult()[0]['guia_de_sepultamento_id']}</b>", WS_INFOR);
    else:
        require '_models/AdminGuiaSepultamento.class.php';
        $cadastra = new AdminGuiaSepultamento;
        $cadastra->ExeCreate($data);
        WSErro("Cadastro realizado com Sucesso AGURDE... A GUIA ESTA SENDO GERADA ", WS_ACCEPT);
        //header("refresh: 5;painel.php?exe=guia_de_sepultamento/gerar_guia " );
        if (!$cadastra->getResult()):
            WSErro($cadastra->getError()[0], $cadastra->getError()[1]);

//        header("refresh: 5;painel.php?exe=guia_de_sepultamento/gerar_guia.php target='black'" );


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

        <link rel="stylesheet" type="text/css" href="css/guia_de_sepultamento.css">
        <link href="../../../css/guia_de_sepultamento.css" rel="stylesheet" type="text/css"/>


    </head>

    <body>

        <div class="alinhar_ao_centro">

            <form class="uppercase form-inline" name="Formcliente" action="" method="post"  >

                <!--            <legend style="text-align: center; color: green">Responsável pelo Funeral:</legend>-->

                <!--INPUT CONTENDO A TAXA DE JUTOS PARA A FUNÇÃO EM JAVA CRIPT calculaParcela(p) NÃO CONVEM HÁBILTAR O MESMO . -->
                <input required type="hidden" class="form-control " name="taxa_juros" id="taxa_juros" value="<?= $taxa_juros->getResult()[0]['taxa'] ?>" readonly="">
                <!--INPUT CONTENDO A DATA ATUAL PARA REGISTRAR O DIA EM QUE FOI REALIZADO A GUIA DE SEPULTAMENTO NO BANCO -->
                <input type="hidden" class="form-control to-uppercase" name="data_do_cadastro" value='<?= date("Y/m/d"); ?>'>


                <div class="form-inline ">



                    <?php if (!isset($data)) { ?>  
                        <label>Nome:</label>
                        <input required style="width:250px;" type="text" class="form-control to-uppercase " name="nome_responsavel"  placeholder="NOME:" autofocus="">
                        <label>CPF:</label>
                        <input required style="width:150px;" type="text" class="form-control to-uppercase cpf" name="cpf_responsavel" placeholder="CPF:">
                        <label>Telefone:</label>
                        <input  required style="width:150px;" type="text" class="form-control to-uppercase tel" name="telefone_responsavel" placeholder="TELEFONE:">
                        <label>Endereço:</label>
                        <input required style="width:320px;" type="text" class="form-control to-uppercase" name="endereco_responsavel"  placeholder="ENDEREÇO:">
                        <label>Nº:</label>
                        <input required style="width:50px;" type="text" class="form-control to-uppercase" name="n_responsavel"  placeholder="Nº:" onkeyup="somenteNumeros(this);">
                        <br><br>
                        <label>Bairro:</label>
                        <input required style="width:250px;" type="text" class="form-control to-uppercase" name="bairro_responsavel"  placeholder="BAIRRO:">
                        <label>Cep:</label>
                        <input required style="width:150px;" type="text" class="form-control to-uppercase cep" name="cep_responsavel"  placeholder="CEP:">

                        <label >Grau de Parentesco:</label>
                        <select  style="width:150px;" class="form-control to-uppercase" name="parentesco_responsavel" required>
                            <option  value="" selected="selected">...</option>
                            <?php
                            $readState = new Read;
                            $readState->ExeRead("grau_de_parentesco", "ORDER BY grau_de_parentesco ASC");
                            foreach ($readState->getResult() as $parentesco):
                                extract($parentesco);
                                echo "<option value=\"{$parentesco['grau_de_parentesco']}\" ";

                                echo "> {$parentesco['grau_de_parentesco']}  </option>";
                            endforeach;
                            ?>                         
                        </select>  

                        <br>

                        <legend style="text-align: center; color: red;">Informações do Falecido (a):</legend>

                        <div class="form-inline ">

                            <label>Nome:</label>
                            <input  required style="width:250px;" type="text" class="form-control to-uppercase"  name="nome_falecido" placeholder="NOME:">


                            <label>CPF:</label>
                            <input required style="width:150px;" type="text" class="form-control to-uppercase cpf" name="cpf_falecido" placeholder="CPF:">


                            <label>Data de Nascimento:</label>
                            <input  required type="date" name="data_nascimento" id="data" class="form-control to-uppercase" >


                            <label>Idade:</label>
                            <input type="nun" style="width:50px;" class="form-control to-uppercase"  name="idade_falecido" id="idade" value="<?= $idade; ?>"  readonly>


                            <label>Data de Falecimento:</label>
                            <input  required style="width:170px;" type="date" name="data_falecimento" class="form-control to-uppercase"  placeholder="NOME:" >

                            <br><br>
                            <label> Sexo:</label>
                            <select  class="form-control to-uppercase" name="sexo_falecido" required="">
                                <option required value="" selected="selected">...</option>
                                <?php
                                $readState->ExeRead("sexo", "ORDER BY sexo ASC");
                                foreach ($readState->getResult() as $tipo_sexo):
                                    extract($tipo_sexo);
                                    echo "<option value=\"{$tipo_sexo['sexo']}\" ";

                                    echo "> {$tipo_sexo['sexo']}  </option>";
                                endforeach;
                                ?>      


                            </select>


                            <label>Local do Falecimento:</label>
                            <input required style="width:310px;" type="text" class="form-control to-uppercase" name="local_do_falecimento" placeholder="LOCAL DO FALECIMENTO:" >
                        </div>

                        <br>
                        <legend style="text-align: center; color: blue; ">Informações do Funeral:</legend>

                        <div class="form-group col-md-2">
                            <label >Típo de Urna:</label>
                            <select  class="form-control to-uppercase" name="tipo_de_urna" required>
                                <option value="" selected="selected">...</option>                           
                                <?php
                                $readState->ExeRead("tipo_de_urna", "ORDER BY tipo_de_urna ASC");
                                foreach ($readState->getResult() as $urna):
                                    extract($urna);
                                    echo "<option value=\"{$urna['tipo_de_urna']}\" ";

                                    echo "> {$urna['tipo_de_urna']}  </option>";
                                endforeach;
                                ?>      
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label >Cemiterio onde foi sepultado:</label>
                            <select  class="form-control to-uppercase" name="cemiterio_cepultado" required>
                                <option value="" selected="selected">...</option>
                                <?php
                                $readState->ExeRead("cemiterios", "ORDER BY nome_cemiterio ASC");
                                foreach ($readState->getResult() as $cemiterios):
                                    extract($urna);
                                    echo "<option value=\"{$cemiterios['nome_cemiterio']}\" ";

                                    echo "> {$cemiterios['nome_cemiterio']}  </option>";
                                endforeach;
                                ?>   

                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label >Cartório onde foi registrado:</label>
                            <select  class="form-control to-uppercase" name="cartorio_registrado" required>
                                <option value="" selected="selected">...</option>
                                <?php
                                $readState->ExeRead("cartorios", "ORDER BY nome_cartorio ASC");
                                foreach ($readState->getResult() as $cartorio):
                                    extract($cartorio);
                                    echo "<option value=\"{$cartorio['nome_cartorio']}\" ";

                                    echo "> {$cartorio['nome_cartorio']}  </option>";
                                endforeach;
                                ?>   

                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Data do Cepultamento:</label>
                            <input required type="date" class="form-control to-uppercase" name="data_cepultamento" placeholder="NOME:" >
                        </div>
                        <br><br><br><br>

                        <div class="form-group col-md-3">
                            <label>Protocolo de Marcação:</label>
                            <input required type="text" class="form-control to-uppercase"  name="protocolo_marcacao" placeholder="Número:" onkeyup="somenteNumeros(this);">
                        </div>

                        <div class="form-inline col-md-2">
                            <label>Valor Do Serviço:</label>
                            <input required type="text" class="form-control to-uppercase  " name="valor_servico" id="valor_servico" placeholder="Valor do Serviço:" onKeyPress="mascara(this, moeda)" maxlength="7">
                        </div>

                        <div class="form-inline col-md-3" required>
                            <label >Tipo de pagamento:</label>
                            <select  class="form-control to-uppercase" name="tipo_de_pagamento" required id="tipo_de_pagamento" onchange="optionCheck()">
                                <option value="" >...</option>
                                <?php
                                $readState->ExeRead("tipo_de_pagamento", "ORDER BY tipo_de_pagamento ASC");
                                foreach ($readState->getResult() as $pagamento):
                                    extract($pagamento);
                                    echo "<option value=\"{$pagamento['tipo_de_pagamento']}\" ";

                                    echo "> {$pagamento['tipo_de_pagamento']}  </option>";
                                endforeach;
                                ?>   
                            </select>

                        </div>

                        <!--                        DIV DESTINADA A PRÓPRIEDADE AVISTA SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                        <div id="avista" class="form-inline col-md-3" style="height:100px;width:300px;border:1px; display: none; ">
                            <label >Valor total avista:</label>
                            <input  type="text" class="form-control   " name="forma_de_pagamento_avista" id="forma_de_pagamento_avista" placeholder="Valor avista:" onclick="somenteNumeros();" readonly>
                        </div>


                        <!--                        DIV DESTINADA A PRÓPRIEDADE CARTÃO SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                        <div id="cartao" class="form-inline col-md-8" style="display: none;">

                            <div class="form-inline col-md-3">
                                <label >Quantidade de Parcelas:</label>
                                <select  class="form-control to-uppercase" name="forma_de_pagamento_cartao_parcelas" onchange="calculaParcela(this.value)" >
                                    <option value="">PARCELAS</option>
                                    <?php
                                    $readState->ExeRead("parcelas", "ORDER BY numero_parcela ASC");
                                    foreach ($readState->getResult() as $parcelas):
                                        extract($parcelas);
                                        echo "<option value=\"{$parcelas['numero_parcela']}\" ";

                                        echo "> {$parcelas['numero_parcela']}  </option>";
                                    endforeach;
                                    ?>   
                                </select>
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Valor da parcela:</label>
                                <input  type="text" class="form-control   " name="forma_de_pagamento_cartao_valor_da_parcela" id="forma_de_pagamento_cartao_valor_da_parcela" placeholder="Valor parcelado:" onclick="somenteNumeros();" readonly>  
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Bandeira do Cartão:</label>
                                <select  class="form-control to-uppercase" name="forma_de_pagamento_cartao_bandeira"  >
                                    <option value="">BANDEIRA</option>
                                    <?php
                                    $readState->ExeRead("bandeiras");
                                    foreach ($readState->getResult() as $bandeiras):
                                        extract($bandeiras);
                                        echo "<option value=\"{$bandeiras['nome_bandeiras']}\" ";

                                        echo "> {$bandeiras['nome_bandeiras']}  </option>";
                                    endforeach;
                                    ?>   
                                </select>
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Número do Cartão:</label>
                                <input  type="text" class="form-control money3  " name="forma_de_pagamento_carta_numero" placeholder="Número do Cartão:" onclick="somenteNumeros();">  
                            </div>

                        </div>

                        <!--                        DIV DESTINADA A PRÓPRIEDADE DINHEIRO + CARTÃO SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                        <div id="dinheiro_e_cartao" class="form-inline col-md-8" style="display: none;" >

                            <div class="form-inline col-md-3">
                                <label >Valor em Dinheiro:</label>
                                <input  type="text" class="form-control   " onKeyPress="mascara(this, moeda)" maxlength="7" name="forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro" id="forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro" placeholder="Valor em Dinheiro:" onchange="calculaDiferenca()">
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Valor a Parcelar:</label>
                                <input  type="text" class="form-control   " onKeyPress="mascara(this, moeda)" maxlength="7" name="forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao" id="forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao" placeholder="Valor parcelado:" onclick="somenteNumeros();" readonly>  
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Quantidade de Parcelas:</label>
                                <select  class="form-control to-uppercase" name="forma_de_pagamento_dinheiro_e_cartao_parcelas" onchange="calculaParcelaComDiferenca(this.value)"  >
                                    <option value="" >parcelas</option>
                                    <?php
                                    $readState->ExeRead("parcelas", "ORDER BY numero_parcela ASC");
                                    foreach ($readState->getResult() as $parcelas):
                                        extract($parcelas);
                                        echo "<option value=\"{$parcelas['numero_parcela']}\" ";

                                        echo "> {$parcelas['numero_parcela']}  </option>";
                                    endforeach;
                                    ?>   
                                </select>
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Valor da parcela:</label>
                                <input  type="text" class="form-control   " name="forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela" id="forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela" placeholder="Valor parcelado:" readonly>  
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Bandeira do Cartão:</label>
                                <select  class="form-control to-uppercase" name="forma_de_pagamento_dinheiro_e_cartao_bandeira">
                                    <option value="">BANDEIRA</option>
                                    <?php
                                    $readState->ExeRead("bandeiras");
                                    foreach ($readState->getResult() as $bandeiras):
                                        extract($bandeiras);
                                        echo "<option value=\"{$bandeiras['nome_bandeiras']}\" ";

                                        echo "> {$bandeiras['nome_bandeiras']}  </option>";
                                    endforeach;
                                    ?>   
                                </select>
                            </div>

                            <div class="form-inline col-md-3">
                                <label >Número do Cartão:</label>
                                <input  type="text" class="form-control money3 " name="forma_de_pagamento_dinheiro_e_cartao_numero" placeholder="Número do Cartão:" onclick="somenteNumeros();">  
                            </div>

                        </div>


                    <?php } else { ?>

                        <?PHP
                        if (isset($data)):

                        else:

                            $data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro'] = '';
                            $data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao'] = '';
                            $data['forma_de_pagamento_dinheiro_e_cartao_parcelas'] = '';
                            $data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela'] = '';
                            $data['forma_de_pagamento_dinheiro_e_cartao_bandeira'] = '';
                            $data['forma_de_pagamento_dinheiro_e_cartao_numero'] = '';
                        endif;
                        ?>


                        <!--FORMULÁRIO COM PERSSISTENCIA DE DADOS -->
                        <label>Nome:</label>
                        <input  style="width:250px;" type="text" class="form-control to-uppercase " value="<?php if (isset($data['nome_responsavel'])) echo $data['nome_responsavel'] ?>"  name="nome_responsavel"  placeholder="NOME:" autofocus="">
                        <label>CPF:</label>
                        <input required style="width:150px;" type="text" class="form-control to-uppercase cpf" value="<?php if (isset($data['cpf_responsavel'])) echo $data['cpf_responsavel'] ?>" name="cpf_responsavel" placeholder="CPF:">
                        <label>Telefone:</label>
                        <input  required style="width:150px;" type="text" class="form-control to-uppercase tel" value="<?php if (isset($data['telefone_responsavel'])) echo $data['telefone_responsavel'] ?>" name="telefone_responsavel" placeholder="TELEFONE:">
                        <label>Endereço:</label>
                        <input required style="width:320px;" type="text" class="form-control to-uppercase" name="endereco_responsavel" value="<?php if (isset($data['endereco_responsavel'])) echo $data['endereco_responsavel'] ?>" placeholder="ENDEREÇO:">
                        <label>Nº:</label>
                        <input required style="width:50px;" type="text" class="form-control to-uppercase" value="<?php if (isset($data['n_responsavel'])) echo $data['n_responsavel'] ?>" name="n_responsavel"  placeholder="Nº:" onkeyup="somenteNumeros(this);">
                        <br><br>
                        <label>Bairro:</label>
                        <input required style="width:250px;" type="text" class="form-control to-uppercase" value="<?php if (isset($data['bairro_responsavel'])) echo $data['bairro_responsavel'] ?>" name="bairro_responsavel"  placeholder="BAIRRO:">
                        <label>Cep:</label>
                        <input required style="width:150px;" type="text" class="form-control to-uppercase cep" value="<?php if (isset($data['cep_responsavel'])) echo $data['cep_responsavel'] ?>" name="cep_responsavel"  placeholder="CEP:">

                        <label >Grau de Parentesco:</label>
                        <select  style="width:150px;" class="form-control to-uppercase" name="parentesco_responsavel" required>
                            <option  value="" selected="selected">...</option>
    <?php
    $readState = new Read;
    $readState->ExeRead("grau_de_parentesco", "ORDER BY grau_de_parentesco ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $parentesco):
            echo" <option value=\"{$parentesco['grau_de_parentesco']}\" ";

            if ($parentesco['grau_de_parentesco'] == $data['parentesco_responsavel']):
                echo ' selected="selected" ';
            endif;

            echo "> {$parentesco['grau_de_parentesco']} </option>";
        endforeach;
    endif;
    ?>                         
                        </select>  

                        <br>

                        <legend style="text-align: center; color: red;">Informações do Falecido (a):</legend>

                        <div class="form-inline ">

                            <label>Nome:</label>
                            <input  required style="width:250px;" type="text" class="form-control to-uppercase" value="<?php if (isset($data['nome_falecido'])) echo $data['nome_falecido'] ?>" name="nome_falecido" placeholder="NOME:">


                            <label>CPF:</label>
                            <input required style="width:150px;" type="text" class="form-control to-uppercase cpf" value="<?php if (isset($data['cpf_falecido'])) echo $data['cpf_falecido'] ?>" name="cpf_falecido" placeholder="CPF:">


                            <label>Data de Nascimento:</label>
                            <input  required type="date" id="data" class="form-control to-uppercase"  value="<?php if (isset($data['data_nascimento'])) echo $data['data_nascimento'] ?>" name="data_nascimento" >


                            <label>Idade:</label>
                            <input type="nun" style="width:50px;" class="form-control to-uppercase"  value="<?php if (isset($data['idade_falecido'])) echo $data['idade_falecido'] ?>" name="idade_falecido" id="idade" value="<?= $idade; ?>"  readonly>


                            <label>Data de Falecimento:</label>
                            <input  required style="width:170px;" type="date" class="form-control to-uppercase" value="<?php if (isset($data['data_falecimento'])) echo $data['data_falecimento'] ?>"  name="data_falecimento"  placeholder="NOME:" >

                            <br><br>
                            <label> Sexo:</label>
                            <select  class="form-control to-uppercase" name="sexo_falecido" required="">
                                <option required value="" selected="selected">...</option>
    <?php
    $readState = new Read;
    $readState->ExeRead("sexo", "ORDER BY sexo ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $tipo_sexo):
            echo" <option value=\"{$tipo_sexo['sexo']}\" ";

            if ($tipo_sexo['sexo'] == $data['sexo_falecido']):
                echo ' selected="selected" ';
            endif;

            echo "> {$tipo_sexo['sexo']} </option>";
        endforeach;
    endif;
    ?>   


                            </select>


                            <label>Local do Falecimento:</label>
                            <input required style="width:310px;" type="text" class="form-control to-uppercase" value="<?php if (isset($data['local_do_falecimento'])) echo $data['local_do_falecimento'] ?>" name="local_do_falecimento" placeholder="LOCAL DO FALECIMENTO:" >
                        </div>

                        <br>
                        <legend style="text-align: center; color: blue; ">Informações do Funeral:</legend>    

                        <div class="form-group col-md-2">
                            <label >Típo de Urna:</label>
                            <select  class="form-control to-uppercase" name="tipo_de_urna" required>
                                <option value="" selected="selected">...</option>                           
    <?php
    $readState = new Read;
    $readState->ExeRead("tipo_de_urna", "ORDER BY tipo_de_urna ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $urna):
            echo" <option value=\"{$urna['tipo_de_urna']}\" ";

            if ($urna['tipo_de_urna'] == $data['tipo_de_urna']):
                echo ' selected="selected" ';
            endif;

            echo "> {$urna['tipo_de_urna']} </option>";
        endforeach;
    endif;
    ?>     
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label >Cemiterio onde foi sepultado:</label>
                            <select  class="form-control to-uppercase" name="cemiterio_cepultado" required>
                                <option value="" selected="selected">...</option>
    <?php
    $readState = new Read;
    $readState->ExeRead("cemiterios", "ORDER BY nome_cemiterio ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $cemiterio):
            echo" <option value=\"{$cemiterio['nome_cemiterio']}\" ";

            if ($cemiterio['nome_cemiterio'] == $data['cemiterio_cepultado']):
                echo ' selected="selected" ';
            endif;

            echo "> {$cemiterio['nome_cemiterio']} </option>";
        endforeach;
    endif;
    ?>     
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label >Cartório onde foi registrado:</label>
                            <select  class="form-control to-uppercase" name="cartorio_registrado" required>
                                <option value="" selected="selected">...</option>
    <?php
    $readState = new Read;
    $readState->ExeRead("cartorios", "ORDER BY nome_cartorio ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $cartorio):
            echo" <option value=\"{$cartorio['nome_cartorio']}\" ";

            if ($cartorio['nome_cartorio'] == $data['cartorio_registrado']):
                echo ' selected="selected" ';
            endif;

            echo "> {$cartorio['nome_cartorio']} </option>";
        endforeach;
    endif;
    ?>    
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Data do Cepultamento:</label>
                            <input required type="date" class="form-control to-uppercase" value="<?php if (isset($data['data_cepultamento'])) echo $data['data_cepultamento'] ?>" name="data_cepultamento" >
                        </div>
                        <br><br><br><br>

                        <div class="form-group col-md-3">
                            <label>Protocolo de Marcação:</label>
                            <input required type="text" class="form-control to-uppercase"  value="<?php if (isset($data['protocolo_marcacao'])) echo $data['protocolo_marcacao'] ?>" name="protocolo_marcacao" placeholder="Número:" onkeyup="somenteNumeros(this);">
                        </div>

                        <div class="form-inline col-md-2">
                            <label>Valor Do Serviço:</label>
                            <input required type="text" class="form-control to-uppercase  " value="<?php if (isset($data['valor_servico'])) echo $data['valor_servico'] ?>" name="valor_servico" id="valor_servico" placeholder="Valor do Serviço:" onKeyPress="mascara(this, moeda)" maxlength="7">
                        </div>
                        <div class="form-inline col-md-3" required>
                            <label >Tipo de pagamento:</label>
                            <select required  class="form-control"  name="tipo_de_pagamento"  id="tipo_de_pagamento" onchange="optionCheck()">
                                <option value="" >...</option>
    <?php
    $readState = new Read;
    $readState->ExeRead("tipo_de_pagamento", "ORDER BY tipo_de_pagamento ASC");

    if (!$readState->getResult()):

    else:
        foreach ($readState->getResult() as $pagamento):
            echo" <option value=\"{$pagamento['tipo_de_pagamento']}\" ";

            if ($pagamento['tipo_de_pagamento'] == $data['tipo_de_pagamento']):
                echo ' selected="selected" ';
            endif;

            echo "> {$pagamento['tipo_de_pagamento']} </option>";
        endforeach;
    endif;
    ?>     
                            </select>

                        </div>

    <?php if (($data['tipo_de_pagamento']) === 'avista') { ?>  
                            <!--                        DIV DESTINADA A PRÓPRIEDADE AVISTA SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                            <div id="avista" class="form-inline col-md-3" style="height:100px;width:300px;border:1px; display: block; ">
                                <label >Valor total avista:</label>
                                <input  type="text" class="form-control"  value="<?php if (isset($data['forma_de_pagamento_avista'])) echo $data['forma_de_pagamento_avista'] ?>"  name="forma_de_pagamento_avista" id="forma_de_pagamento_avista"  onclick="somenteNumeros();" readonly>
                            </div>


    <?php } if (($data['tipo_de_pagamento']) === 'cartao') { ?>


                            <!--                        DIV DESTINADA A PRÓPRIEDADE CARTÃO SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                            <div id="cartao" class="form-inline col-md-8" style="display: block;">

                                <div class="form-inline col-md-3">
                                    <label >Quantidade de Parcelas:</label>
                                    <select  class="form-control to-uppercase" name="forma_de_pagamento_cartao_parcelas" onchange="calculaParcela(this.value)" >
                                        <option value="">PARCELAS</option>
        <?php
        $readState = new Read;
        $readState->ExeRead("parcelas", "ORDER BY numero_parcela ASC");

        if (!$readState->getResult()):

        else:
            foreach ($readState->getResult() as $parcela):
                echo" <option value=\"{$parcela['numero_parcela']}\" ";

                if ($parcela['numero_parcela'] == $data['forma_de_pagamento_cartao_parcelas']):
                    echo ' selected="selected" ';
                endif;

                echo "> {$parcela['numero_parcela']} </option>";
            endforeach;
        endif;
        ?>     
                                    </select>
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Valor da parcela:</label>
                                    <input  type="text" class="form-control   " value="<?php if (isset($data['forma_de_pagamento_cartao_valor_da_parcela'])) echo $data['forma_de_pagamento_cartao_valor_da_parcela'] ?>" name="forma_de_pagamento_cartao_valor_da_parcela" id="forma_de_pagamento_cartao_valor_da_parcela" placeholder="Valor parcelado:" onclick="somenteNumeros();" readonly>  
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Bandeira do Cartão:</label>
                                    <select  class="form-control to-uppercase" name="forma_de_pagamento_cartao_bandeira">
                                        <option value="">BANDEIRA</option>
        <?php
        $readState = new Read;
        $readState->ExeRead("bandeiras");

        if (!$readState->getResult()):

        else:
            foreach ($readState->getResult() as $bandeiras):
                echo" <option value=\"{$bandeiras['nome_bandeiras']}\" ";

                if ($bandeiras['nome_bandeiras'] == $data['forma_de_pagamento_cartao_bandeira']):
                    echo ' selected="selected" ';
                endif;

                echo "> {$bandeiras['nome_bandeiras']} </option>";
            endforeach;
        endif;
        ?>    
                                    </select>
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Número do Cartão:</label>
                                    <input  type="text" class="form-control money3  " value="<?php if (isset($data['forma_de_pagamento_carta_numero'])) echo $data['forma_de_pagamento_carta_numero'] ?>" name="forma_de_pagamento_carta_numero" placeholder="Número do Cartão:" onclick="somenteNumeros();">  
                                </div>

                            </div>
    <?php } ?>

                        <?php if (($data['tipo_de_pagamento']) === 'dinheiro_e_cartao') { ?>  

                            <!--                        DIV DESTINADA A PRÓPRIEDADE DINHEIRO + CARTÃO SELECIONADA NO SELEC FORMA DE PAGAMENTO:-->
                            <div id="dinheiro_e_cartao" class="form-inline col-md-8" style="display: block;" >


                                <div class="form-inline col-md-3">
                                    <label >Valor em Dinheiro:</label>
                                    <input  type="text" class="form-control   " onKeyPress="mascara(this, moeda)" maxlength="7" value="<?php if (isset($data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro'])) echo $data['forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro'] ?>" name="forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro" id="forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro" placeholder="Valor em Dinheiro:" onchange="calculaDiferenca()">
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Valor a Parcelar:</label>
                                    <input  type="text" class="form-control   " onKeyPress="mascara(this, moeda)" maxlength="7" value="<?php if (isset($data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao'])) echo $data['forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao'] ?>" name="forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao" id="forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao" placeholder="Valor parcelado:" onclick="somenteNumeros();" readonly>  
                                </div>


                                <div class="form-inline col-md-3">
                                    <label >Quantidade de Parcelas:</label>
                                    <select  class="form-control to-uppercase" name="forma_de_pagamento_dinheiro_e_cartao_parcelas" onchange="calculaParcelaComDiferenca(this.value)"  >
                                        <option value="" >parcelas</option>
        <?php
        $readState = new Read;
        $readState->ExeRead("parcelas", "ORDER BY numero_parcela ASC");

        if (!$readState->getResult()):

        else:
            foreach ($readState->getResult() as $parcela):
                echo" <option value=\"{$parcela['numero_parcela']}\" ";

                if ($parcela['numero_parcela'] == $data['forma_de_pagamento_dinheiro_e_cartao_parcelas']):
                    echo ' selected="selected" ';
                endif;

                echo "> {$parcela['numero_parcela']} </option>";
            endforeach;
        endif;
        ?>     
                                    </select>
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Valor da parcela:</label>
                                    <input  type="text" class="form-control   " value="<?php if (isset($data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela'])) echo $data['forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela'] ?>" name="forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela" id="forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela" placeholder="Valor parcelado:" readonly>  
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Bandeira do Cartão:</label>
                                    <select  class="form-control to-uppercase" name="forma_de_pagamento_dinheiro_e_cartao_bandeira">
                                        <option value="">BANDEIRA</option>
        <?php
        $readState = new Read;
        $readState->ExeRead("bandeiras");

        if (!$readState->getResult()):

        else:
            foreach ($readState->getResult() as $bandeiras):
                echo" <option value=\"{$bandeiras['nome_bandeiras']}\" ";

                if ($bandeiras['nome_bandeiras'] == $data['forma_de_pagamento_dinheiro_e_cartao_bandeira']):
                    echo ' selected="selected" ';
                endif;

                echo "> {$bandeiras['nome_bandeiras']} </option>";
            endforeach;
        endif;
        ?>    
                                    </select>
                                </div>

                                <div class="form-inline col-md-3">
                                    <label >Número do Cartão:</label>
                                    <input  type="text" class="form-control money3 " value="<?php if (isset($data['forma_de_pagamento_dinheiro_e_cartao_numero'])) echo $data['forma_de_pagamento_dinheiro_e_cartao_numero'] ?>" name="forma_de_pagamento_dinheiro_e_cartao_numero" placeholder="Número do Cartão:" onclick="somenteNumeros();">  
                                </div>
                            </div>
    <?php } ?>


<?php } ?>   


                </div>

                <br><br><br><br> <br><br><br><br><br><br><br>

                <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm" id="SendPostForm" />


            </form>
        </div>


    </body>

</html> 

<!--//calculando juros -->

<?php ?>
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


<script type="text/javascript">
    //FUNÇÃO ABAIXO ESTA  ATIVA NO INPUT FORMA DE PAGAMENTO  A MESMA SERVE PARA ATIVAR OU DESATIVAR AS DV AVISTA / CARTAO / DINHEIRO
//COM BASE NO VALOR QUE FOI SELECIONADO NO SELECT OPTION FORMA DE PAGAMENTO  

    function optionCheck() {
        var option = document.getElementById("tipo_de_pagamento").value;
        var valor_servico = document.getElementById('valor_servico').value;
        if (option === "avista") {
            document.getElementById("avista").style.display = "block";
            document.getElementById("forma_de_pagamento_avista").value = valor_servico;
            document.getElementById("cartao").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";

        }
        if (option === "cartao") {
            document.getElementById("cartao").style.display = "block";
            document.getElementById("avista").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";
        }

        if (option === "dinheiro_e_cartao") {
            document.getElementById("dinheiro_e_cartao").style.display = "block";
            document.getElementById("avista").style.display = "none";
            document.getElementById("cartao").style.display = "none";
        }

        if (option === "") {
            document.getElementById("cartao").style.display = "none";
            document.getElementById("avista").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";
        }
    }

//FORMA DE PAGAMENTO EM CARTÃO + JUROS APARTIR DA 4 PARCELAS 
    function calculaParcela(p) {
        if (p === "") {
            alert('Selecione a quantidade de parcelas!');
        }
        if (p >= 4) {
            var taxa = arrumaValorParaFazerConta(document.getElementById('taxa_juros').value);
            var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
            var valor_parcela = valor_servico / p;
            var parcela_taxa = valor_parcela * taxa / 100;
            document.getElementById("forma_de_pagamento_cartao_valor_da_parcela").value = numeroParaMoeda(valor_parcela + parcela_taxa);

        }

        else {
            var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
            var valor_parcela = valor_servico / p;
            document.getElementById("forma_de_pagamento_cartao_valor_da_parcela").value = numeroParaMoeda(valor_parcela);
        }
    }

    function calculaDiferenca() {
        var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
        var forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro').value);
        var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = (valor_servico - forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro);
        document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao);
    }
//FORMA DE PAGAMENTO EM DINHEIRO + CARTÃO, JUROS APARTIR DA 4 PARCELAS 
    function calculaParcelaComDiferenca(p) {
        if (p === "") {
            alert('Selecione a quantidade de parcelas!');
        }
        if (p >= 4) {
            var taxa2 = arrumaValorParaFazerConta(document.getElementById('taxa_juros').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela = forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao / p;
            var parcela_taxa2 = forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela * taxa2 / 100;
            document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela + parcela_taxa2);

        }

        else {
            var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela = forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao / p;
            document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela);
        }
    }

    function arrumaValorParaFazerConta(valor) {
        if (valor.length <= 6) {
            valor = valor.replace(',', '.');
        } else {
            valor = valor.replace('.', '');
            valor = valor.replace(',', '.');
        }
        return valor;
    }

    function numeroParaMoeda(n, c, d, t) {
        c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function moeda(v) {
        v = v.replace(/\D/g, "") //permite digitar apenas números
        v = v.replace(/[0-9]{12}/, "inválido") //limita pra máximo 999.999.999,99
        v = v.replace(/(\d{1})(\d{8})$/, "$1.$2") //coloca ponto antes dos últimos 8 digitos
        v = v.replace(/(\d{1})(\d{5})$/, "$1.$2") //coloca ponto antes dos últimos 5 digitos
        v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2") //coloca virgula antes dos últimos 2 digitos
        return v;
    }
</script>



<script type="text/javascript">

    document.getElementById("data").addEventListener('change', function () {
        var data = new Date(this.value);
        if (isDate_(this.value) && data.getFullYear() > 1900)
            document.getElementById("idade").value = calculateAge(this.value);
    });

    function calculateAge(dobString) {
        var dob = new Date(dobString);
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var birthdayThisYear = new Date(currentYear, dob.getMonth(), dob.getDate());
        var age = currentYear - dob.getFullYear();
        if (birthdayThisYear > currentDate) {
            age--;
        }
        return age;
    }

    function calcular(data) {
        var data = document.form.nascimento.value;
        alert(data);
        var partes = data.split("/");
        var junta = partes[2] + "-" + partes[1] + "-" + partes[0];
        document.form.idade.value = (calculateAge(junta));
    }

    var isDate_ = function (input) {
        var status = false;
        if (!input || input.length <= 0) {
            status = false;
        } else {
            var result = new Date(input);
            if (result == 'Invalid Date') {
                status = false;
            } else {
                status = true;
            }
        }
        return status;
    }

</script>

