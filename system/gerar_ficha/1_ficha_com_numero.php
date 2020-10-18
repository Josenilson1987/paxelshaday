
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="CSS/style_ficha_pag.css">
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">
        <meta charset="UTF-8">


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
        <fieldset><!--fieldset-linha do formulario-->
            <legend>PARA GERAR A FICHA INFORME O CPF DO TITULAR + O NÚMERO DA FICHA </legend>
        </fieldset><!--fieldset-linha do formulario-->	
        <div id="principal">

            <form action="system/gerar_ficha/gerar_ficha_1.php" method="post" class="form-inline" target="black">

                <!--            <form action="painel?exe=ficha_de_pagamento/gera_ficha_4" method="post" class="form-inline">-->
                <div id="tabela1">

                    <div id="painel_form1" class="well well-lg">
                        <label>1º TITULAR</label>                        
                        <input   class="   form-control cpf " required style="width: 150px;" type="text" name="cpf_titular_1"   maxlength="11" autofocus/>
                        <label>NÚMERO FICHA</label>
                        <input   class="   form-control  " required style="width: 50px;" type="text" name="n_ficha_1"   onkeyup="somenteNumeros(this);"/>

                        


                    </div>	
                    <button type="submit" name="gerar_ficha" class="btn btn-primary">GERAR FICHA</button>
                </div>

            </form>	
        </div>
    </body>
</html>