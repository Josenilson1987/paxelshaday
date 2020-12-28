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
      WSErro("Este cpf já esta cadastrado como dependente, para cadastrar como titular não alterar o nome do titular", WS_ALERT);
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

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema para Funeraria">
  <meta name="author" content="Josenilson Pereira">



  <title>Template de login, usando Bootstrap.</title>
  <link href="../../_app/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Principal CSS do Bootstrap -->
  <link href="_app/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos customizados para esse template -->

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
  <div class="form_create article ">   
      <form name="Formcliente" action="" method="post"  >

        <legend>Cadastrar Cliente </legend>
        <div class="form-inline  ">

          <input type="text" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj']; ?>' style="display: none;" />
          <input type="text" name="lixeira" value='<?= $lixeira; ?>' style="display: none;" />

          <div class="input-group-prepend  ">
            <span class="input-group-text" id="basic-addon3">CPF:</span>
            <input type="text" name="cpf_titular" class="form-control to-uppercase" value="<?php if (isset($cpf)) echo $cpf ?>" readonly>
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Ano da Inscrição:</span>
            <input required type="text" name="ano_inscricao" class="form-control to-uppercase" autofocus onkeyup="somenteNumeros(this);">
          </div>

          <div class=" input-group-prepend ">
            <span class=" input-group-text" id="basic-addon3">Nome:</span>
            <input required type="text" name="titular_nome" class="form-control to-uppercase" style="min-width:500px;">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">RG:</span>
            <input required type="text" name="rg" class="form-control rg">
          </div> <br><br><br>

          <div class="input-group-prepend ">
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
          </div>

          <div class="input-group-prepend  ">
            <span class="input-group-text" id="basic-addon3">Endereço:</span>
            <input required type="text" name="endereco" class="form-control to-uppercase" style="min-width:500px;">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nº:</span>
            <input required type="text" name="n_endereco" class="form-control" onkeyup="somenteNumeros(this);">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Bairro:</span>
            <input required type="text" name="bairro" class="form-control to-uppercase" style="min-width:400px;">
          </div><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Cep:</span>
            <input required type="text" name="cep" class="form-control cep" style="width:150px;">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Estado:</span>
            <select required class="j_loadstate form-control" name="estado">
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

          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Cidade:</span>
            <select required class="j_loadcity form-control" name="cidade">
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
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Naturalidade:</span>
            <input required type="text" name="naturalidade" class="form-control to-uppercase" style="min-width:200px;">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Telefone:</span>
            <input required type="text" name="telefone" class="form-control tel" style="width:150;">
          </div><br><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Data de nascimento:</span>
            <input required type="date" name="data_de_nascimento" class="form-control to-uppercase">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Profissão:</span>
            <input required type="text" name="profissao" class="form-control to-uppercase" style="width:150;">
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Religião:</span>
            <select required name="religiao" class="form-control" value="">
              <option value="" selected="selected">RELIGIÃO</option>
              <option value="catolico">CATÓLICO</option>
              <option value="protestante">PROTESTANTE</option>
              <option value="crista">CRISTA</option>
              <option value="tafricana">MATRIZ AFRICANA</option>
              <option value="espirita">ESPIRITA</option>
              <option value="tjeova">TESTEMINHAS DE JEOVA</option>
            </select>
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nacionalidade:</span>
            <input required type="text" name="nacionalidade" class="form-control to-uppercase" style="width:150;">
          </div><br><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nome do Pai:</span>
            <input required type="text" name="nome_do_pai" class="form-control to-uppercase" style="min-width:250px;">
          </div>



          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">É Vivo ? </span>
            <select required name="pai_vivo_falecido" class="form-control">
              <option value="" selected="selected"> SIM OU NÃO ?</option>
              <option value="sim">SIM</option>
              <option value="nao">NÃO</option>
            </select>
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nome da Mãe:</span>
            <input required type="text" name="nome_da_mae" class="form-control to-uppercase" style="min-width:250px;">
          </div>



          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">É Viva? </span>
            <select required name="mae_viva_falecida" class="form-control">
              <option value="" selected="selected"> SIM OU NÃO ?</option>
              <option value="sim">SIM</option>
              <option value="nao">NÃO</option>
            </select>
          </div><br><br>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Valor do plano:</span>
            <select required name="valor_do_plano" class="form-control">
              <option value="" selected="selected">VALOR DO PLANO</option>
              <option value="40,00">R$ 40,00</option>
              <option value="70,00">R$ 70,00</option>
              <option value="90,00">R$ 90,00</option>
            </select>
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Data do Primeiro Pagamento:</span>
            <input required type="date" name="data_primeiro_pagamento" class="form-control to-uppercase">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text">Nº Primeira Parcela:</span>
            <input required type="text" name="n_parcela" class="form-control to-uppercase" style="width: 40px;" value="1" readonly>
          </div><br><br><br><br>

          <div class="input-group-prepend ">
            <span class="input-group-text">Modelo de urna:</span>
            <select required name="modelo_de_urna" id="modelo_de_urna" class="form-control">
              <option value="" selected="selected">MODELO DE URNA</option>
              <option value="com-visor">COM VISOR </option>
              <option value="sem-visor">SEM VISOR </option>
            </select>


            <span class="input-group-text">Tipo de Urna:</span>
            <select required name="tipo_de_urna" class="form-control">
              <option value="" selected="selected">TIPO DE URNA</option>
              <option value="parreira">PARREIRA</option>
              <option value="varam">VARAM</option>
              <option value="varamzinho">VARAMZINHO</option>
              <option value="alcadura">ALÇA DURA</option>
              <option value="alacaparreira">ALÇA PAREIRA</option>
            </select>

            <span class="input-group-text" id="basic-addon3">Tipo de Plano:</span>
            <select required name="tipo_de_plano" class="form-control" value="">
              <option value="" selected="selected">TIPO DE PLANO</option>
              <option value="a">A</option>
              <option value="b">B</option>
            </select>
          </div>



        </div>

        <div class="form-group"></div>
        <div id="botoes">
          <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm" id="SendPostForm" />
          <a class="btn  btn-danger"href="painel.php">Cancelar</a> 
        </div>

      </form>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</html>