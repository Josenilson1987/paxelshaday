
<?php
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);

    var_dump($data);
endif;
?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8"/>
        <title>GERADOR DE RECIBO</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">



        <link rel="stylesheet" href="css/style_gerador.css"/>


 

    </head>
    <body>

        <div class="content form_create">
            <article>

                <div class="well well-lg form-inline to-uppercase " >

                    <form  action="system/recibo/recibo.php" method="post" >


                        <legend>Gerar Recibo</legend>
                        <input  style="width: 300px;" name="responsavel" type="text"  size="60" class="form-control to-uppercase to-uppercase"  required placeholder="DIGITE O NOME DO RESPOSAVEL" />
                        <input style="width: 220px" name="cpf_responsavel" type="text" id="cpf_responsavel" size="30"   class="form-control cpf" required placeholder="DIGITE O CPF"  maxlength="14"   />                                                 
                        <input style="width: 250px" name="valor_recibo" type="text" id="valor_recibo" size="30" class="form-control to-uppercase money2" required placeholder="VALOR DO RECIBO: " maxlength="8"   />
                        <input style="width: 300px" name="extenso" type="text" id="extenso" size="30"  class="form-control to-uppercase" required placeholder="VALOR POR EXTENSO: EXEMPLO  MIL" />
                        <input style="width: 220px" name="falecido" type="text" id="falecido" size="60" class="form-control to-uppercase" required placeholder="NOME DO FALECIDO (A):" />
                        <label>Data Do Falecimento </label>
                        <input style="width: 170px" name="data_falecimento" type="date" class="form-control to-uppercase" required />   
                        <br>
                        <input style="display: none;" type="text" class="form-control to-uppercase" name="data_atual" value="<?= date('d/m/Y H:i:s'); ?>"/>



                        <!--BOTOES-->
                        <div id="botoes">
                            <input type="submit" class="btn bg-primary" value="Gerar Recibo" name="SendPostForm" />
                            <button type="reset" name="Reset" id="button" value="LIMPAR CAMPOS" class="btn btn-success">LIMPAR CAMPO<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><!---ICONE NO BOTÃO---></button>
                            
                        </div>
                        <!--BOTOES-->
                    </form>

                </div>



            </article>
        </div>


    </body>
</html>
