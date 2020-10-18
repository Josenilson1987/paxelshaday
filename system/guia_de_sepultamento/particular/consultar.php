<?php
$userlogin = $_SESSION['empresa_cnpj'];

if (!class_exists('Login')) :
    header('Location: ../painel.php');
    die;
endif;

$taxa_juros = new Read;
$taxa_juros->ExeRead("taxa_juros");


$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$data["consultar"] = str_replace([".", "-"], "", $data["consultar"]); // 00000000000﻿




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
        <link rel="stylesheet" type="text/css" href="css/consultar_titular.css">



    </head>

    <body>

        <h3 style="text-align: center">Para consultar uma guia de sepultamento escolha uma das opções abaixo :</h3>

        <hr>            
        <div class="input-group-text " style="text-align: center">
            <h3>

                <label style="color: #900 ">CPF do titular:</label>

                <label style="color: #900 ">CPF do falecido:</label>
            </h3>
        </div>

        <form  name="Formcliente" action="" method="post"  >
            <div class="alinhar_ao_centro"> 
                <!--INPUT CONTENDO A DATA ATUAL PARA REGISTRAR O DIA EM QUE FOI REALIZADO A GUIA DE SEPULTAMENTO NO BANCO -->
                <input required style="width:500px;" type="text" class="form-control to-uppercase cpf" name="consultar" placeholder="DIGITE UMAS DAS OPÇÕES ACIMA:">
                <br>
                <input  type="submit" class="btn btn-success" value="Buscar" name="SendPostForm" id="SendPostForm" />      
            </div>

        </form>

        <table class="table table-striped">

            <thead>

            <th>Nome do responsável:</th>
            <th>CPF do responsável:</th>
            <th>Nome do falecido (a):</th>
            <th>CPF do falecido (a):</th>
            <th>Visualizar Guia</th>



        </thead>

        <?php
// REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR

        

        $consulta = new Read;
       // $consulta->ExeRead("guia_de_sepultamento", " WHERE cpf_responsavel='{$data['consultar']}'", " WHERE cpf_falecido='{$data['consultar']}' ");
        $consulta->ExeRead("guia_de_sepultamento", " WHERE cpf_responsavel='{$data['consultar']}' OR cpf_falecido='{$data['consultar']}' ");


//        var_dump($consulta);
        
        if ($consulta->getResult()):
            foreach ($consulta->getResult() as $consulta):
                ?>                
                <tr class="to-uppercase">

                    <td><?= $consulta["nome_responsavel"]; ?></td>
                    <td><?= $consulta["cpf_responsavel"]; ?></td>
                    <td><?= $consulta["nome_falecido"]; ?></td>
                    <td><?= $consulta["cpf_falecido"]; ?></td>

                    <td> <a class="btn  btn-danger" href=""> editar_dep</a></td>
                </tr> 

                <?php
            endforeach;
        elseif(!$consulta->getResult()):
            
        endif;
        ?>


    </table>

</body>

</html> 

<!--//calculando juros -->

<?php ?>
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


<script type="text/javascript">
    //FUNÇÃO ABAIXO ESTA  ATIVA NO INPUT FORMA DE PAGAMENTO  A MESMA SERVE PARA ATIVAR OU DESATIVAR AS DV AVISTA / CARTAO / DINHEIRO
//COM BASE NO VALOR QUE FOI SELECIONADO NO SELECT OPTION FORMA DE PAGAMENTO  

    function optionCheck() {
        var option = document.getElementById("tipo_de_pagamento").value;
        var valor_servico = document.getElementById('valor_servico').value;
        if (option === "avista") {
            document.getElementById("avista").style.display = "block";
            document.getElementById("forma_de_pagamento_avista").value = valor_servico;
            document.getElementById("cartao").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";

        }
        if (option === "cartao") {
            document.getElementById("cartao").style.display = "block";
            document.getElementById("avista").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";
        }

        if (option === "dinheiro_e_cartao") {
            document.getElementById("dinheiro_e_cartao").style.display = "block";
            document.getElementById("avista").style.display = "none";
            document.getElementById("cartao").style.display = "none";
        }

        if (option === "") {
            document.getElementById("cartao").style.display = "none";
            document.getElementById("avista").style.display = "none";
            document.getElementById("dinheiro_e_cartao").style.display = "none";
        }
    }

//FORMA DE PAGAMENTO EM CARTÃO + JUROS APARTIR DA 4 PARCELAS 
    function calculaParcela(p) {
        if (p === "") {
            alert('Selecione a quantidade de parcelas!');
        }
        if (p >= 4) {
            var taxa = arrumaValorParaFazerConta(document.getElementById('taxa_juros').value);
            var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
            var valor_parcela = valor_servico / p;
            var parcela_taxa = valor_parcela * taxa / 100;
            document.getElementById("forma_de_pagamento_cartao_valor_da_parcela").value = numeroParaMoeda(valor_parcela + parcela_taxa);

        }

        else {
            var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
            var valor_parcela = valor_servico / p;
            document.getElementById("forma_de_pagamento_cartao_valor_da_parcela").value = numeroParaMoeda(valor_parcela);
        }
    }

    function calculaDiferenca() {
        var valor_servico = arrumaValorParaFazerConta(document.getElementById('valor_servico').value);
        var forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro').value);
        var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = (valor_servico - forma_de_pagamento_dinheiro_e_cartao_valor_dinheiro);
        document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao);
    }
//FORMA DE PAGAMENTO EM DINHEIRO + CARTÃO, JUROS APARTIR DA 4 PARCELAS 
    function calculaParcelaComDiferenca(p) {
        if (p === "") {
            alert('Selecione a quantidade de parcelas!');
        }
        if (p >= 4) {
            var taxa2 = arrumaValorParaFazerConta(document.getElementById('taxa_juros').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela = forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao / p;
            var parcela_taxa2 = forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela * taxa2 / 100;
            document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela + parcela_taxa2);

        }

        else {
            var forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao = arrumaValorParaFazerConta(document.getElementById('forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao').value);
            var forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela = forma_de_pagamento_dinheiro_e_cartao_valor_parcelado_cartao / p;
            document.getElementById("forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela").value = numeroParaMoeda(forma_de_pagamento_dinheiro_e_cartao_valor_da_parcela);
        }
    }

    function arrumaValorParaFazerConta(valor) {
        if (valor.length <= 6) {
            valor = valor.replace(',', '.');
        } else {
            valor = valor.replace('.', '');
            valor = valor.replace(',', '.');
        }
        return valor;
    }

    function numeroParaMoeda(n, c, d, t) {
        c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function moeda(v) {
        v = v.replace(/\D/g, "") //permite digitar apenas números
        v = v.replace(/[0-9]{12}/, "inválido") //limita pra máximo 999.999.999,99
        v = v.replace(/(\d{1})(\d{8})$/, "$1.$2") //coloca ponto antes dos últimos 8 digitos
        v = v.replace(/(\d{1})(\d{5})$/, "$1.$2") //coloca ponto antes dos últimos 5 digitos
        v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2") //coloca virgula antes dos últimos 2 digitos
        return v;
    }
</script>




