<?php
if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;



$cpf_titular = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);
$ficha_pagamento_id = filter_input(INPUT_GET, 'delete', FILTER_DEFAULT);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (!isset($data['SendPostForm'])):

else:
    $read = new Read;
    $read->FullRead("select * from ficha_pagamento where cpf_titular={$cpf_titular} order by numero_ficha desc limit 1 ");

    if (!$read->getResult()):

        header('Location: painel.php?exe=/ficha_de_pagamento/index');
    else:
        $data = $read->getResult()[0];

        unset($data['ficha_pagamento_id']);
        require '_models/AdminFicha2.class.php';
        $acrecentar = new AdminFicha2;
        $acrecentar->ExeCreate($data);
        WSErro("Cadastro realizado com Sucesso ", WS_ACCEPT);
        header("refresh: 5;painel.php?exe=ficha_de_pagamento/listar&listar=true&cpf_titular=" . "$cpf_titular");
        if (!$acrecentar->getResult()):
            WSErro($acrecentar->getError()[0], $acrecentar->getError()[1]);
        endif;

    endif;
   endif;

require '_models/AdminFicha.class.php';
$Deletar = new AdminFicha();
$Deletar->ExeDelete($ficha_pagamento_id);
if ($Deletar->getResult()):
     header("Location: ".$_SERVER['HTTP_REFERER']."");

    else:
        $data = $Deletar->getResult()[0];
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
        $listarficha->FullRead("select * from ficha_pagamento where cpf_titular={$cpf_titular} ORDER BY ano_inicial ");
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
                    <td><a class="btn  btn-success" href='painel.php?exe=ficha_de_pagamento/update&ficha_pagamento_id=<?= $listarficha["ficha_pagamento_id"]; ?>'>Editar</a></td>

                    <td>
                        <form action="system/gerar_ficha/visualizar_ficha.php" method="post" class="form-inline" target="blank">

                            <input style="width:260px; font-size: 13px;" type="hidden" name="titular_nome"  class="form-control to-uppercase" value="<?php if (isset($listarficha)) echo $listarficha['titular_nome']; ?>" readonly/>

                            <input style="width:200px; font-size: 13px; " type="hidden" name="cpf_titular"  class="form-control" value="<?php if (isset($listarficha)) echo $listarficha['cpf_titular']; ?>" readonly/>

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




                            <input type="submit" class="btn btn-primary" value="Gerar" name="SendPostForm"/>
                            
                             <td><a href="painel.php?exe=ficha_de_pagamento/listar&delete=<?= $listarficha["ficha_pagamento_id"]; ?>" onclick="return confirm('Confirmar exclusão de registro?');"class="btn btn-danger">Delete</a></td>
                             
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
