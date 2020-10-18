<?php
if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$cpf = filter_input(INPUT_GET, 'cpf', FILTER_VALIDATE_INT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (!isset($data['SendPostForm'])):

else:
    $read = new Read;
    $read->FullRead("select * from ficha_pagamento where cpf={$cpf}  order by numero_ficha desc limit 1");
//$read->FullRead("select * from ficha_pagamento  where cpf = cpf={$cpf} order by numero_ficha desc limit 1");
//$read->FullRead("select * from ficha_pagamento
//numero_ficha = (select max(numero_ficha) from ficha_pagamento) and cpf={$cpf}");

    if (!$read->getResult()):
        echo "error";
//    //header('Location: painel.php');
    else:
        $data = $read->getResult()[0];

        unset($data['ficha_pagamento_id']);
        require '_models/AdminFicha2.class.php';
        $acrecentar = new AdminFicha2;
        $acrecentar->ExeCreate($data);
        WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);
        header("refresh: 5;painel.php?exe=gerar_ficha/listar&listar=true&cpf=" . "$cpf");
        if (!$acrecentar->getResult()):
            WSErro($acrecentar->getError()[0], $acrecentar->getError()[1]);
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

    </head>

    <body>

        <form method="POST">
            <button type="submit" class="btn btn-primary" name="SendPostForm">Gerar Nova Ficha</button> 
        </form>
        <table class="table table-striped">

            <thead>

            <th>Titular:</th>
            <th>Nº Ficha:</th>
            <th>Ano da inscrição:</th>
            <th>Ano Inicial:</th>
            <th>Ano Final:</th>
            <th>Valor:</th>

            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>
            <th>Nº</th>





        </thead>

        <?php
// REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR


        $listarficha = new Read;
        $listarficha->FullRead("select * from ficha_pagamento where cpf={$cpf} ORDER BY numero_ficha ");
        if (!$listarficha->getResult()):
            WSErro("Não exite fichas cadastradas com este titular ", WS_INFOR);
        else:

            foreach ($listarficha->getResult() as $listarficha):
                ?>                
                <tr class="to-uppercase">

                    <td><?= $listarficha["titular_nome"]; ?></td>
                    <td><?= $listarficha["numero_ficha"]; ?></td>
                    <td><?= $listarficha["ano_inscricao"]; ?></td>
                    <td><?= $listarficha["ano_inicial"]; ?></td>
                    <td><?= $listarficha["ano_final"]; ?></td>
                    <td style="color: red"><b><?= $listarficha["valor_parcela"]; ?></b></td>
                    <td><?= $listarficha["parcela_01"]; ?></td>
                    <td><?= $listarficha["parcela_02"]; ?></td>
                    <td><?= $listarficha["parcela_03"]; ?></td>
                    <td><?= $listarficha["parcela_04"]; ?></td>
                    <td><?= $listarficha["parcela_05"]; ?></td>
                    <td><?= $listarficha["parcela_06"]; ?></td>
                    <td><?= $listarficha["parcela_07"]; ?></td>
                    <td><?= $listarficha["parcela_08"]; ?></td>
                    <td><?= $listarficha["parcela_09"]; ?></td>
                    <td><?= $listarficha["parcela_10"]; ?></td>
                    <td><?= $listarficha["parcela_11"]; ?></td>
                    <td><?= $listarficha["parcela_12"]; ?></td>
                    <td><a class="btn  btn-success" href='painel.php?exe=gerar_ficha/update&ficha_pagamento_id=<?= $listarficha["ficha_pagamento_id"]; ?>'>Editar</a></td>

                    <td>
                        <form action="system/ficha_de_pagamento/gera_ficha_1.php" method="post" class="form-inline" target="blank">

                            <input style="width:260px; font-size: 13px;" type="hidden" name="titular_nome"  class="form-control to-uppercase" value="<?php if (isset($listarficha)) echo $listarficha['titular_nome']; ?>" readonly/>

                            <input style="width:200px; font-size: 13px; " type="hidden" name="cpf"  class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['cpf']; ?>" readonly/>

                            <input style="width:90px; font-size: 13px; " type="hidden" name="n_contrato"  class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['n_contrato']; ?>" readonly/>

                            <input style="width:155px;font-size: 13px" type="hidden" name="ano_inscricao"  required class="form-control" value="<?php if (isset($listarficha)) $listarficha['ano_inscricao']; ?>" readonly/>

                            <input style="width:100px;font-size: 13px" type="hidden" name="ano_inicial"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['ano_inicial']; ?>" readonly/>

                            <input style="width:100px;font-size: 13px" type="hidden" name="ano_final"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['ano_final']; ?>" readonly/>

                            <input style="width:100px;font-size: 13px" type="hidden" name="mes_inicial"  required class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['mes_inicial']; ?>" readonly/>


                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_01"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_01']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_02"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_02']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_03"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_03']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_04"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_04']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_05"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_05']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_06"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_06']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_07"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_07']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_08"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_08']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_09"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_09']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_10"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_10']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_11"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_11']; ?>" readonly/>
                            <input style="width:40px; font-size: 13px" type="hidden" name="parcela_12"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['parcela_12']; ?>" readonly/>



                            <input style="width:100px; font-size: 13px" type="hidden" name="valor_parcela"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['valor_parcela']; ?>" readonly/>


                            <input  required class="form-control to-uppercase"  style="width: 150px;" type="hidden" name="data_nascimento"  value="<?php if (isset($listarficha)) echo $listarficha['data_cadastrada']; ?>" readonly>


                            <input style="width:170px; font-size: 13px" type="hidden" name="numero_ficha"   class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['numero_ficha']; ?>" readonly/>




                            <input type="submit" class="btn btn-primary" value="Visualizar" name="SendPostForm"/>
                           

                        </form>
                    </td>                        
                </tr> 

                <?php
            endforeach;
        endif;
        ?>
    </table>   
</body>

</html>
