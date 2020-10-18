<?php
if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$ficha_pagamento_id = filter_input(INPUT_GET, 'ficha_pagamento_id', FILTER_VALIDATE_INT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$cpf = $data['cpf'];



if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    $data["cpf"] = str_replace([".", "-"], "", $data["cpf"]); // 00000000000﻿


    require('_models/AdminFicha.class.php');
    $cadastra = new AdminFicha;
    $cadastra->ExeUpdate($ficha_pagamento_id, $data);
    WSErro($cadastra->getError()[0], $cadastra->getError()[1]);

    header("refresh: 2;painel.php?exe=ficha_de_pagamento/listar&listar=true&cpf=" . "$cpf");

else:
    $listarficha = new Read;
    $listarficha->ExeRead("ficha_pagamento", "WHERE ficha_pagamento_id = :id", "id={$ficha_pagamento_id}");
    if (!$listarficha->getResult()):
//     header('Location: painel.php');
    else:
        $data = $listarficha->getResult()[0];
    endif;
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </head>

    <body>

    <td>
        <form action="" method="post" class="form-inline">
            <label>Nome do Titular:</label>
            <input style="width:260px; font-size: 13px;" type="text" name="titular_nome"  class="form-control to-uppercase" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['titular_nome']; ?>" readonly/>
            <label>Cpf:</label>
            <input style="width:200px; font-size: 13px; " type="text" name="cpf"  class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['cpf']; ?>" readonly/>
            <label>Nº do Contrato:</label>
            <input style="width:90px; font-size: 13px; " type="text" name="n_contrato"  class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['n_contrato']; ?>" readonly/>
            <label>Ano da inscricao:</label>
            <input style="width:80px;font-size: 13px" type="text" name="ano_inscricao"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['ano_inscricao']; ?>" readonly/>
            <br>

            <label>Mes Inicial:</label>
            <input style="width:100px;font-size: 13px" type="text" name="mes_inicial"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['mes_inicial']; ?>" />
            <label>Ano inicial:</label>
            <input style="width:100px;font-size: 13px" type="text" name="ano_inicial"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['ano_inicial']; ?>" />
            <label>Ano final:</label>
            <input style="width:100px;font-size: 13px" type="text" name="ano_final"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['ano_final']; ?>" />
            <label>Número da Fixa:</label>
            <input style="width:70px; font-size: 13px" type="text" name="numero_ficha"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['numero_ficha']; ?>" readonly/>
            <label>Data do cadastro:</label>
            <input style="width:120px; font-size: 13px" type="text" name="data_cadastrada"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['data_cadastrada']; ?>" readonly/>
            <br>

            <legend></legend>
            <label>Número das parcelas:</label>
            <br>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_01"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_01']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_02"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_02']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_03"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_03']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_04"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_04']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_05"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_05']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_06"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_06']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_07"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_07']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_08"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_08']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_09"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_09']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_10"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_10']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_11"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_11']; ?>" readonly/>
            <input style="width:40px; font-size: 13px" type="text" name="parcela_12"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['parcela_12']; ?>" readonly/>
            <br><br>
            <label>Valor da Parcela:</label>

            <b><input style="width:100px; font-size: 13px; color: red;" type="text" name="valor_parcela"   class="form-control money" value="<?php if (isset($listarficha)) echo $listarficha->getResult()[0]['valor_parcela']; ?>" /></b>

            <input type="submit" class="btn btn-primary" value="Atualizar" name="SendPostForm"/>
            <input type="button" class="btn btn-default" value="Voltar" onClick="history.go(-1)">

        </form>
    </td>   

</body>

</html>
