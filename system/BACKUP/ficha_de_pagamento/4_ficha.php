
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="CSS/style_ficha_pag.css">
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title>Ficha De pagamento 4</title>
    </head>
    <body>
        <div id="principal">
            <form action="system/ficha_de_pagamento/gera_ficha_4.php" method="post" class="form-inline" target="black">
                <!--            <form action="painel?exe=ficha_de_pagamento/gera_ficha_4" method="post" class="form-inline">-->
                <div id="tabela1">
                    <fieldset><!--fieldset-linha do formulario-->
                        <legend>PARA GERAR A FICHA INFORME O CPF DO TITULAR</legend>
                    </fieldset><!--fieldset-linha do formulario-->	
                    <div id="painel_form1"class="well well-lg">


                        <input   class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular_1"   maxlength="11" autofocus>
                        <input   class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular_2" maxlength="11" >
                        <input   class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular_3"  maxlength="11" >
                        <input   class="form-control to-uppercase cpf "  style="width: 160px;" type="text" name="cpf_titular_4"   maxlength="11" >


                    </div>	
                    <button type="submit" name="gerar_ficha" class="btn btn-primary">GERAR FICHA</button>
                </div>

            </form>	
        </div>
    </body>
</html>