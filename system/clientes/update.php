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
if (!empty($data['SendPostForm'])) :
  $data['lixeira'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1');
  $data["cpf_titular"] = str_replace([".", "-"], "", $data["cpf_titular"]); // 00000000000﻿

  unset($data['SendPostForm']);

  // var_dump($data);

  require('_models/AdminClientes.class.php');
  $cadastra = new AdminClientes;
  $cadastra->ExeUpdate($clientes_id, $data);

  header("refresh: 5;painel.php");

  WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
else :
  $read = new Read;
  $read->ExeRead("clientes", "WHERE clientes_id = :id", "id={$clientes_id}");
  if (!$read->getResult()) :
  //header('Location: painel.php');
  else :
    $data = $read->getResult()[0];
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
  <div class="form_create">
      <form name="Formcliente" action="" method="post">

        <legend>Atualizar Cliente </legend>
        <div class="form-inline  ">

          <input type="hidden" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj'] ?>' />
          <input type="hidden" name="lixeira" id="lixeira" value='<?= $data['lixeira'] ?>' />
          <input type="hidden" name="clientes_id" id="clientes_id" value='<?= $data['clientes_id'] ?>' />

          <div class="input-group-prepend  ">
            <span class="input-group-text" id="basic-addon3">CPF:</span>
            <input type="text" name="cpf_titular" class="form-control to-uppercase" value="<?php if (isset($data)) echo $data['cpf_titular']; ?>" readonly>
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Ano da Inscrição:</span>
            <input required type="text" name="ano_inscricao" class="form-control to-uppercase" autofocus onkeyup="somenteNumeros(this);" value="<?php if (isset($data)) echo $data['ano_inscricao']; ?>">
          </div>

          <div class=" input-group-prepend ">
            <span class=" input-group-text" id="basic-addon3">Nome:</span>
            <input required type="text" name="titular_nome" class="form-control to-uppercase" style="min-width:500px;" value="<?php if (isset($data)) echo $data['titular_nome']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">RG:</span>
            <input required type="text" name="rg" class="form-control rg" value="<?php if (isset($data)) echo $data['rg']; ?>">
          </div> <br><br><br>





          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Estado Civil:</span>
            <select class="form-control to-uppercase" name="estado_civil">
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("estado_civil");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['estado_civil']}\" ";

                  if ($ses['estado_civil'] == $data['estado_civil']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['estado_civil']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div>

          <div class="input-group-prepend  ">
            <span class="input-group-text" id="basic-addon3">Endereço:</span>
            <input required type="text" name="endereco" class="form-control to-uppercase" style="min-width:500px;" value="<?php if (isset($data)) echo $data['endereco']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nº:</span>
            <input required type="text" name="n_endereco" class="form-control" onkeyup="somenteNumeros(this);" value="<?php if (isset($data)) echo $data['n_endereco']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Bairro:</span>
            <input required type="text" name="bairro" class="form-control to-uppercase" style="min-width:400px;" value="<?php if (isset($data)) echo $data['bairro']; ?>">
          </div><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Cep:</span>
            <input required type="text" name="cep" class="form-control cep" style="width:150px;" value="<?php if (isset($data)) echo $data['cep']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Estado:</span>
            <select class="j_loadstate form-control to-uppercase" name="estado">
              <option value="" selected> Selecione o estado </option>
              <?php
              $readState = new Read;
              $readState->ExeRead("app_estados", "ORDER BY estado_nome ASC");
              foreach ($readState->getResult() as $estado) :
                extract($estado);
                echo "<option value=\"{$estado_id}\" ";
                if (isset($data['estado']) && $data['estado'] == $estado_id) : echo 'selected';
                endif;
                echo "> {$estado_uf} / {$estado_nome} </option>";
              endforeach;
              ?>
            </select>

          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Cidade:</span>
            <select class="j_loadcity form-control to-uppercase" name="cidade">
              <?php if (!isset($data['cidade'])) : ?>
                <option value="" selected disabled> Selecione antes um estado </option>
              <?php
              else :
                $City = new Read;
                $City->ExeRead("app_cidades", "WHERE estado_id = :uf ORDER BY cidade_nome ASC", "uf={$data['estado']}");
                if ($City->getRowCount()) :
                  foreach ($City->getResult() as $cidade) :
                    extract($cidade);
                    echo "<option value=\"{$cidade_id}\" ";
                    if (isset($data['cidade']) && $data['cidade'] == $cidade_id) :
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
            <input required type="text" name="naturalidade" class="form-control to-uppercase" style="min-width:200px;" value="<?php if (isset($data)) echo $data['naturalidade']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Telefone:</span>
            <input required type="text" name="telefone" class="form-control tel" style="width:150;" value="<?php if (isset($data)) echo $data['telefone']; ?>">
          </div><br><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Data de nascimento:</span>
            <input required type="date" name="data_de_nascimento" class="form-control to-uppercase" value="<?php if (isset($data)) echo $data['data_de_nascimento']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Profissão:</span>
            <input required type="text" name="profissao" class="form-control to-uppercase" style="width:150;" value="<?php if (isset($data)) echo $data['profissao']; ?>">
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Religião:</span>
            <select required name="religiao" class="form-control to-uppercase" value="" style="width: 190px;">

              <option value=""> escolha a religião </option>
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("religioes");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['religioes']}\" ";

                  if ($ses['religioes'] == $data['religiao']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['religioes']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nacionalidade:</span>
            <input required type="text" name="nacionalidade" class="form-control to-uppercase" style="width:150;" value="<?php if (isset($data)) echo $data['nacionalidade']; ?>">
          </div><br><br><br>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nome do Pai:</span>
            <input required type="text" name="nome_do_pai" class="form-control to-uppercase" style="min-width:250px;" value="<?php if (isset($data)) echo $data['nome_do_pai']; ?>">
          </div>



          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">É Vivo ? </span>
            <select required name="pai_vivo_falecido" class="form-control to-uppercase" value="">
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("sim_ou_nao");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['sim_ou_nao']}\" ";

                  if ($ses['sim_ou_nao'] == $data['pai_vivo_falecido']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['sim_ou_nao']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div>


          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Nome da Mãe:</span>
            <input required type="text" name="nome_da_mae" class="form-control to-uppercase" style="min-width:250px;" value="<?php if (isset($data)) echo $data['nome_da_mae']; ?>">
          </div>



          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">É Viva? </span>
            <select required name="mae_viva_falecida" class="form-control to-uppercase" value="">
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("sim_ou_nao");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['sim_ou_nao']}\" ";

                  if ($ses['sim_ou_nao'] == $data['pai_vivo_falecido']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['sim_ou_nao']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div><br>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Valor do plano:</span>
            <select required name="valor_do_plano" class="form-control to-uppercase" value="">


              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("valor_do_plano");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['valor_do_plano']}\" ";

                  if ($ses['valor_do_plano'] == $data['valor_do_plano']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['valor_do_plano']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text" id="basic-addon3">Data do Primeiro Pagamento:</span>
            <input required type="date" name="data_primeiro_pagamento" class="form-control to-uppercase" value="<?php if (isset($data)) echo $data['data_primeiro_pagamento']; ?>">
          </div>

          <div class="input-group-prepend ">
            <span class="input-group-text">Nº Primeira Parcela:</span>
            <input required type="text" name="n_parcela" class="form-control to-uppercase" style="width: 40px;" value="1" readonly>
          </div><br><br><br><br>

          <div class="input-group-prepend ">
            <span class="input-group-text">Modelo de urna:</span>
            <select required name="modelo_de_urna" class="form-control to-uppercase" value="">

              <option value=""> tipo_de_urna </option>
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("modelo_de_urna");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['modelo_de_urna']}\" ";

                  if ($ses['modelo_de_urna'] == $data['modelo_de_urna']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['modelo_de_urna']} </option>";
                endforeach;
              endif;
              ?>
            </select>


            <span class="input-group-text">Tipo de Urna:</span>
            <select required name="tipo_de_urna" class="form-control to-uppercase" value="">

              <option value=""> tipo_de_urna </option>
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("tipo_de_urna");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['tipo_de_urna']}\" ";

                  if ($ses['tipo_de_urna'] == $data['tipo_de_urna']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['tipo_de_urna']} </option>";
                endforeach;
              endif;
              ?>
            </select>

            <span class="input-group-text" id="basic-addon3">Tipo de Plano:</span>
            <select required name="tipo_de_plano" class="form-control to-uppercase" style="width: 150px;" value="">
              <?php
              $ReadSes = new Read;
              $ReadSes->ExeRead("tipo_de_plano");

              if (!$ReadSes->getResult()) :

              else :
                foreach ($ReadSes->getResult() as $ses) :
                  echo " <option value=\"{$ses['tipo_de_plano']}\" ";

                  if ($ses['tipo_de_plano'] == $data['tipo_de_plano']) :
                    echo ' selected="selected" ';
                  endif;

                  echo "> {$ses['tipo_de_plano']} </option>";
                endforeach;
              endif;
              ?>
            </select>
          </div>



        </div>

        <div class="form-group"></div>
        <div id="botoes">

          <a class="btn  btn-primary" href="painel.php?exe=clientes/index">Voltar</a>
          <input type="submit" class="btn btn-warning" value="Atualizar" name="SendPostForm" />
          <input type="submit" class="btn btn-danger" value="Deletar" name="SendPostForm" onclick="return  confirm('Deseja mesmo deletar o cadastro ?');" />
          <a class="btn  btn-success" href="painel.php?exe=ficha_de_pagamento/listar&listar=&cpf_titular=<?= $data["cpf_titular"] ?>&nome_titular=<?= $data["titular_nome"] ?>">Gerar Ficha</a>
        </div><br><br>


        <legend> Abaixo os pendentes do Cliente <?= $data['titular_nome']; ?></legend>

        <table class="table table-striped">

          <thead>

            <th>Nome:</th>
            <th>Data Nascimento:</th>
            <th>Grau De Parentesco:</th>
            <th>Editar</th>


          </thead>

          <?php
          // REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR
          extract($data);
          $cpf_titular = $data["cpf_titular"];

          $listardependentes = new Read;

          $listardependentes->ExeRead("dependentes", "WHERE titular_cpf='$cpf_titular'");



          if (!$listardependentes->getResult()) :
            WSErro("Não exite dependentes cadastrados com este titular ", WS_INFOR);
          else :

            foreach ($listardependentes->getResult() as $listardependentes) :
          ?>
              <tr class="to-uppercase">

                <td><?= $listardependentes["dependente_nome"]; ?></td>
                <td><?= $listardependentes["dependente_data_nascimento"]; ?></td>
                <td><?= $listardependentes["dependente_grau_de_parentesco"]; ?></td>

                <td> <a class="btn  btn-danger" href="painel.php?exe=dependentes/update&update=&cpf_titular<?= $data["cpf_titular"] ?>&nome_titular=<?= $data["titular_nome"] ?>&dependentes_id=<?= $listardependentes["dependentes_id"] ?>&dependente_nome=<?= $listardependentes["dependente_nome"] ?>" name="editar"> editar_dep</a></td>


              </tr>

          <?php
            endforeach;
          endif;
          ?>


        </table>

    </form>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</html>