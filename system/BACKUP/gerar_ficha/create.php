<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$titular_nome = filter_input(INPUT_GET, 'titular_nome', FILTER_DEFAULT);
$cpf = filter_input(INPUT_GET, 'cpf', FILTER_SANITIZE_STRING);
$n_contrato = filter_input(INPUT_GET, 'n_contrato', FILTER_SANITIZE_STRING);
$ano_inscricao = filter_input(INPUT_GET, 'ano_inscricao', FILTER_DEFAULT);

$data["cpf"] = str_replace([".", "-"], "", $data["cpf"]); // 00000000000﻿

$parcelas = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$numero_ficha = 1;
?>

<?php
if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    require '_models/AdminFicha.class.php';
    $cadastra = new AdminFicha;
    $cadastra->ExeCreate($data);
    WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);
    header("refresh: 5;painel.php?exe=gerar_ficha/listar&listar=true&cpf=" . "$cpf");
    //header("refresh: 5;painel.php");
    if (!$cadastra->getResult()):
        WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    else:

    endif;
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/cadastrar_dependentes.css">

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

                <div class="well well-lg Form_cliente form-inline content form_create  " >

                    <form class="uppercase" name="Formcliente" action="" method="post" id="Formcliente" >

                        <div class="well well-lg form-inline">


                            <label>Nome Titular:</label>
                            <input style="width:260px; font-size: 13px;" type="text" name="titular_nome"  class="form-control to-uppercase" value="<?php if (isset($titular_nome)) echo $titular_nome; ?>" readonly/>
                            <label>Cpf Titular:</label>
                            <input style="width:200px; font-size: 13px; " type="text" name="cpf"  class="form-control" value="<?php if (isset($cpf)) echo $cpf; ?>" readonly/>
                            <label>Nº Contrato:</label>
                            <input style="width:90px; font-size: 13px; " type="text" name="n_contrato"  class="form-control" value="<?php if (isset($n_contrato)) echo $n_contrato; ?>" readonly/>
                            <label>Ano da Inscrição:</label>
                            <input style="width:155px;font-size: 13px" type="text" name="ano_inscricao"  required class="form-control" value="<?php if (isset($ano_inscricao)) echo $ano_inscricao; ?>" readonly/>
                            <label>Ano inicial:</label>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_inicial"  required class="form-control" value="<?php if (isset($ano_inscricao)) echo $ano_inscricao; ?>" readonly/>
                            <label>Ano Final:</label>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_final"  required class="form-control" value="<?php if (isset($ano_inscricao)) echo $ano_inscricao + 1; ?>" readonly/>
                            <!--inicio do seletor-->	
                            <label>Mes:</label>
                            <select name="mes_inicial" required class="form-control to-uppercase">
                                <option value="">MES INICIAL</option>
                                <option value="JANEIRO">JANEIRO</option>
                                <option value="FEVEREIRO">FEVEREIRO</option>
                                <option value="MARCO">MARÇO</option>
                                <option value="ABRIL">ABRIL</option>
                                <option value="MAIO">MAIO</option>
                                <option value="JUNHO">JUNHO</option>
                                <option value="JULHO">JULHO</option>
                                <option value="AGOSTO">AGOSTO</option>
                                <option value="SETEMBRO">SETEMBRO</option>
                                <option value="OUTUBRO">OUTUBRO</option>
                                <option value="NOVEMBRO">NOVEMBRO</option>
                                <option value="DEZEMBRO">DEZEMBRO</option>
                            </select>	 
                            <!--fim do seletor-->
                            <label>Número da Parcela:</label>
                            <input style="width:170px; font-size: 13px" type="text" name="parcela_01"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[0]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_02"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[1]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_03"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[2]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_04"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[3]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_05"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[4]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_06"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[5]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_07"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[6]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_08"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[7]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_09"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[8]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_10"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[9]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_11"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[10]; ?>" readonly/>
                            <input style="width:170px; font-size: 13px" type="hidden" name="parcela_12"   class="form-control" value="<?php if (isset($parcelas)) echo $parcelas[11]; ?>" readonly/>


                            <label>Valor da Parcela:</label>
                            <input style="width:100px;font-size: 13px" type="text" name="valor_parcela"  required class="form-control money"/>
                            <label>Data atual:</label>
                            <input style="width:150px;font-size: 13px" type="date" name="data_cadastrada"  required class="form-control "/>

                            <input style="width:170px; font-size: 13px" type="hidden" name="numero_ficha"   class="form-control" value="<?php if (isset($numero_ficha)) echo $numero_ficha; ?>" readonly/>



                        </div>	
                        <input type="submit" class="btn btn-success" value="Cadastrar" name="SendPostForm"/>
                    </form>


            </article>
        </div>


    </body>

</html>
