
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="CSS/style_ficha_pag.css">
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">
        <meta charset="UTF-8">
        <title>Ficha De pagamento 4</title>
    </head>
    <body>
        <div id="principal">
            <form action="system/gerar_ficha/gerar_ficha_2.php" method="post" class="form-group" target="black">
                <!--            <form action="painel?exe=ficha_de_pagamento/gera_ficha_4" method="post" class="form-inline">-->
                <div id="tabela1">
                    <fieldset><!--fieldset-linha do formulario-->
                        <legend>PARA GERAR A FICHA INFORME O CPF DO TITULAR</legend>
                    </fieldset><!--fieldset-linha do formulario-->	
                    <div id="painel_form1" class="well well-lg">

                        <input class="form-control"  type="hidden" name="n_ficha_1" value="0"/>
                        <input class="form-control"  type="hidden" name="n_ficha_2" value="0"/>
                        <input class="form-control"  type="hidden" name="n_ficha_3" value="0"/>
                        <input class="form-control"  type="hidden" name="n_ficha_4" value="0"/>
                        
                        <label>1º TITULAR</label>
                        <input   class="   form-control to-uppercase cpf " required style="width: 160px;" type="text" name="cpf_titular_1"   maxlength="11" autofocus/>
                        <label>2º TITULAR</label>
                        <input   class="   form-control to-uppercase cpf "  required style="width: 160px;" type="text" name="cpf_titular_2" maxlength="11" >


                    </div>	
                    <button type="submit" name="gerar_ficha" class="btn btn-primary">GERAR FICHA</button>
                </div>

            </form>	
        </div>
    </body>
</html>