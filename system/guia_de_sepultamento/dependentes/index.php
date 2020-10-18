<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$userlogin['empresa_cnpj'];



$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["cpf"] = str_replace([".", "-"], "", $data["cpf"]); // 00000000000﻿



if (!empty($data['SendPostForm'])):
    unset($data['SendPostForm']);





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




        <div class="content form_create">
            <article>

                <div class="well well-lg Form_cliente form-inline content form_create " >

                    <form class="uppercase" name="Formcliente" action="" method="post"  >

                        <input type="text" name="usuarios_empresa_cnpj" value='<?= $userlogin['empresa_cnpj']; ?>' style="display: none;" />
                    

                        <legend>Funeral Dependete do plano:</legend>
                       
                      
                    </form>

                </div>
            </article>
        </div>
    </body>



</html>
