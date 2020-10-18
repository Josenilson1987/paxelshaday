
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="CSS/style_ficha_pag.css">

        <meta charset="UTF-8">

    </head>
    <body>
        <div id="principal">
            <form action="system/ficha_de_pagamento/gera_ficha_3.php" method="post" class="form-inline">

                <div id="tabela1">
                    <fieldset><!--fieldset-linha do formulario-->
                        <legend>Ficha 1</legend>
                    </fieldset><!--fieldset-linha do formulario-->	
                    <div id="painel_form1"class="well well-lg">
                        <div  id="form-group" class="form-group" >

                            <input style="width:200px; font-size: 13px; " type="text" name="N_contrato"  required class="form-control" placeholder="NUMERO DO CONTRATO" />
                            <input style="width:155px;font-size: 13px" type="text" name="ano_inscricao"  required class="form-control" placeholder="ANO DA INSCRIÇÃO "/>
                            <input style="width:260px;font-size: 13px" type="text" name="titular"  required class="form-control to-uppercase" placeholder="NOME DO TITULAR"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_inicial"  required class="form-control" placeholder="ANO INICIAL"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_final"  required class="form-control" placeholder="ANO FINAL"/>
                            <!--inicio do seletor-->	
                            <select name="mes_inicial" required class="form-control">
                                <option value="">MES INICIAL</option>
                                <option value="JANEIRO">JANEIRO</option>
                                <option value="FEVEREIRO">FEVEREIRO</option>
                                <option value="MARÇO">MARÇO</option>
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
                            <input style="width:170px; font-size: 13px" type="text" name="n_parcela"  required class="form-control" placeholder="NÚMERO DA PARCELA"/>
                            <input style="width:170px;font-size: 13px" type="text" name="v_parcela"  required class="form-control money" placeholder="VALOR DA PARCELA"/>


                        </div>	
                    </div>	

                </div>
                <!---------------------------------------------------->
                <!---------------------------------------------------->
                <div id="tabela2">
                    <fieldset><!--fieldset-linha do formulario-->
                        <legend>Ficha 2</legend>
                    </fieldset><!--fieldset-linha do formulario-->	
                    <div id="painel_form1"class="well well-lg">
                        <div  id="form-group" class="form-group" >

                            <input style="width:200px; font-size: 13px; " type="text" name="N_contrato2"  required class="form-control" placeholder="NUMERO DO CONTRATO" />
                            <input style="width:155px;font-size: 13px" type="text" name="ano_inscricao2"  required class="form-control" placeholder="ANO DA INSCRIÇÃO "/>
                            <input style="width:260px;font-size: 13px" type="text" name="titular2"  required class="form-control to-uppercase" placeholder="NOME DO TITULAR"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_inicial2"  required class="form-control" placeholder="ANO INICIAL"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_final2"  required class="form-control" placeholder="ANO FINAL"/>
                            <!--inicio do seletor-->	
                            <select name="mes_inicial2" required class="form-control">
                                <option value="">MES INICIAL</option>
                                <option value="JANEIRO2">JANEIRO</option>
                                <option value="FEVEREIRO2">FEVEREIRO</option>
                                <option value="MARÇO2">MARÇO</option>
                                <option value="ABRIL2">ABRIL</option>
                                <option value="MAIO2">MAIO</option>
                                <option value="JUNHO2">JUNHO</option>
                                <option value="JULHO2">JULHO</option>
                                <option value="AGOSTO2">AGOSTO</option>
                                <option value="SETEMBRO2">SETEMBRO</option>
                                <option value="OUTUBRO2">OUTUBRO</option>
                                <option value="NOVEMBRO2">NOVEMBRO</option>
                                <option value="DEZEMBRO2">DEZEMBRO</option>
                            </select>
                            <!--fim do seletor-->
                            <input style="width:170px; font-size: 13px" type="text" name="n_parcela2"  required class="form-control" placeholder="NÚMERO DA PARCELA"/>
                            <input style="width:170px;font-size: 13px" type="text" name="v_parcela2"  required class="form-control money" placeholder="VALOR DA PARCELA"/>

                        </div>	
                    </div>		
                </div>


                <div id="tabela3">
                    <fieldset><!--fieldset-linha do formulario-->
                        <legend>Ficha 3</legend>
                    </fieldset><!--fieldset-linha do formulario-->	
                    <div id="painel_form1"class="well well-lg">
                        <div  id="form-group" class="form-group" >

                            <input style="width:200px; font-size: 13px; " type="text" name="N_contrato3"  required class="form-control" placeholder="NUMERO DO CONTRATO" />
                            <input style="width:155px;font-size: 13px" type="text" name="ano_inscricao3"  required class="form-control" placeholder="ANO DA INSCRIÇÃO "/>
                            <input style="width:260px;font-size: 13px" type="text" name="titular3"  required class="form-control to-uppercase" placeholder="NOME DO TITULAR"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_inicial3"  required class="form-control" placeholder="ANO INICIAL"/>
                            <input style="width:100px;font-size: 13px" type="text" name="ano_final3"  required class="form-control" placeholder="ANO FINAL"/>
                            <!--inicio do seletor-->	
                            <select name="mes_inicial3" required class="form-control">
                                <option value="">MES INICIAL</option>
                                <option value="JANEIRO3">JANEIRO</option>
                                <option value="FEVEREIRO3">FEVEREIRO</option>
                                <option value="MARÇO3">MARÇO</option>
                                <option value="ABRIL3">ABRIL</option>
                                <option value="MAIO3">MAIO</option>
                                <option value="JUNHO3">JUNHO</option>
                                <option value="JULHO3">JULHO</option>
                                <option value="AGOSTO3">AGOSTO</option>
                                <option value="SETEMBRO3">SETEMBRO</option>
                                <option value="OUTUBRO3">OUTUBRO</option>
                                <option value="NOVEMBRO3">NOVEMBRO</option>
                                <option value="DEZEMBRO3">DEZEMBRO</option>
                            </select>
                            <!--fim do seletor-->
                            <input style="width:170px; font-size: 13px" type="text" name="n_parcela3"  required class="form-control" placeholder="NÚMERO DA PARCELA"/>
                            <input style="width:170px;font-size: 13px" type="text" name="v_parcela3"  required class="form-control money" placeholder="VALOR DA PARCELA"/>

                        </div>	
                    </div>
                </div>
                <button type="submit" name="gerar_ficha" class="btn btn-primary">GERAR FICHA</button>
            </form>
        </div>
    </body>
</html>