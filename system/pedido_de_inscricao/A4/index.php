
<?php
$cpf_titular = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);

$ReadTitular = new read;
$ReadTitular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");



if (!$ReadTitular->getResult()):
  
else:
    foreach ($ReadTitular->getResult() as $ReadTitular):

    endforeach;
endif;

?>

<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/pedido_de_inscricao.css" />
        <script src="js/prefixfree.min.js"></script>

        
        
        <!--ESTILO DESTINADO A FOLHA A4 DA PAGINA -->
        <style>

            /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
            body {
                background: rgb(204,204,204); 
            }
            page {
                background: white;
                display: block;
                /* margin: 0 auto; */
                margin-bottom: 0.5cm; 
                margin-top: -60px; 
                /* box-shadow: 0 0 0.5cm rgba(0,0,0,0.8); */
                font-size:15px;
                /* border:solid #000 2px; */
                box-sizing: border-box;
                padding: 40px;

            }

            h4{

                align-left: 5px; 

            }
            page[size="A4"] {  
                width: 100%;
                /* height: 29.7cm;  */
                

            }
            page[size="A4"][layout="portrait"] {
                width: 100%;
                /* height: 21cm;   */
            }

            .caixa_de_texto{ 
                padding: 10px 5px 10px 5px; 

                margin: 10px 10px 10px 5px; 

                width: 100%; 

                height: 100px; 

            }


            @media print {
                body, page {
                    margin: 0;
                    box-shadow: 0;
                    .ocultabotao {
                        display: none;
                    }
                }
            }

        </style>

        <!--ESTILO DESTINADO A FOLHA A4 DA PAGINA -->



    </head>

    <body>
        
        <?php 
        
        $valor_plano1 = '40,00';
        $valor_plano2 = '70,00';
        $valor_plano3 = '90,00';
       
        $porcentagem ;
      
     
        if ($ReadTitular['valor_do_plano'] === $valor_plano1):
            $porcentagem = '4%';
        else:
           $porcentagem = '6%'; 
        endif;
         
        
        ?>

       
    <page size="A4">

        <br>
        <img src ="imagens/Figura1.JPG" style =" width:970px; height:160px;">

        <H4 ALIGN="left"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK"> Contribuinte: <?= strtoupper($ReadTitular["titular_nome"]) ?></FONT></H4>    
        <H4 ALIGN="left"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK">Residência  <?= strtoupper($ReadTitular["endereco"]) ?>  Nº   <?= strtoupper($ReadTitular["n_endereco"]) ?></FONT></H4>    
        <H4 ALIGN="left"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK">
        Bairro: <?= strtoupper($ReadTitular["bairro"]) ?> 
        Estado:
       <?php
        $readestado = new Read;
        $readestado->ExeRead("app_estados");

        if (!$readestado->getResult()):

        else:
            foreach ($readestado->getResult() as $readestado):
                if ($ReadTitular["estado"] === $readestado["estado_id"]):
                    echo $readestado["estado_uf"];
                endif;
            endforeach;
        endif;
        ?> 
        
        Cidade:
        <?php
        $readCidade = new Read;
        $readCidade->ExeRead("app_cidades");

        if (!$readCidade->getResult()):

        else:
            foreach ($readCidade->getResult() as $readCidade):
                if ($ReadTitular["cidade"] === $readCidade["cidade_id"]):
                    echo $readCidade["cidade_nome"];
                endif;
            endforeach;
        endif;
        ?>      

        </FONT></H4>        
        <H4 ALIGN="left"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK">Telefone: <?= strtoupper($ReadTitular["telefone"]) ?> Naturalidade: <?= strtoupper($ReadTitular["naturalidade"]) ?> Entrada R$:  <?= $ReadTitular["valor_do_plano"] ?></FONT></H4>    
        <H4 ALIGN="center"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK"></FONT></H4>    
        <H4 ALIGN="center"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK"></FONT></H4>    
        <H4 ALIGN="left"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK">mais (11) parcelas de R$: <?= $ReadTitular["valor_do_plano"] ?></FONT></H4>    

        <table class="tabela1">


            <tr>
                <td>Cart. Identidade (RG): <?= strtoupper($ReadTitular["rg"]) ?></td>
                <td>CPF: <?= strtoupper($ReadTitular["cpf_titular"]) ?></td>
            </tr>
            <tr>
                <td>Profissão: <?= strtoupper($ReadTitular["profissao"]) ?></td>
                <td>Nacionalidade: <?= strtoupper($ReadTitular["nacionalidade"]) ?></td>
            </tr>

            <tr>
                <td>Estado Civil: <?= strtoupper($ReadTitular["estado_civil"]) ?></td>
                <td>Plano: <?= strtoupper($ReadTitular["tipo_de_plano"]) ?></td>
            </tr>

            <tr>
                <td>1º Pagamento: <?= date('d/m/Y', strtotime($ReadTitular["data_primeiro_pagamento"])); ?></td>
                <td>Valor do plano: <?= $ReadTitular["valor_do_plano"] ?></td>
            </tr>

           

        </table>


        <H4 ALIGN="justify"><FONT FACE="Arial" SIZE="1,7" COLOR="BLACK">Apos dois anos de contrato, passando se 24 meses a parir da data do primeiro vencimento,  e não utilizados dos serviços  funerais contratados, o contribuinte poderá anular o mesmo não tendo nenhuma custa, se durante este período os serviços forem utilizados, o contribuinte se responsabiliza a pagar o contrato ate o termino do prazo mínimo estipulado de 24 meses .Caso havendo interesse de continuar com o contrato apos a conclusão dos 24 meses o contribuinte pagara uma taxa de manutenção de <?= $porcentagem?> ao ano em cima do salário mínimo vigente .</FONT></H4>
        <H3 ALIGN="justify"><FONT FACE="Arial" SIZE="2" COLOR="BLACK" class=""><b>Atenção: Caso o beneficiado sendo ele titular ou dependente, venha a óbito em um ambiente famíliar não sendo um hospítal e não tendo acompanhamento médico, o tramite legal sera acionar o IML a funeraria pax el shaday não forcnece atestado médico. </b></FONT></H3>

        <table class="tabela2">   
            <tr>
                <td style="">BENEFICIÁRIOS E DEPENDENTES</td>
            </tr>
        </table>

        <table class="table table-striped">

            <thead>

            <th>Nome:</th>
            <th>RG:</th>
            <th>CPF:</th>
            <th>Data  Nascimento:</th>
            <th>Grau De Parentesco:</th>



            </thead>

            <?php
// REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR
            extract($ReadTitular);
            $ReadTitular["cpf_titular"] = $cpf_titular;

            $listardependentes = new Read;

            $listardependentes->ExeRead("dependentes", "WHERE cpf_titular='$cpf_titular'");



            if (!$listardependentes->getResult()):
                WSErro("Não exite dependentes cadastrados com este titular ", WS_INFOR);
            else:

                foreach ($listardependentes->getResult() as $listardependentes):
                    ?>                
                    <tr class="to-uppercase">

                        <td><?= $listardependentes["dependentes_nome"]; ?></td>
                        <td><?= $listardependentes["rg"]; ?></td>
                        <td><?= $listardependentes["cpf_dep"]; ?></td>
                        <td><?= $listardependentes["data_nascimento"]; ?></td>
                        <td><?= $listardependentes["grau_de_parentesco"]; ?></td>




                    </tr> 

                    <?php
                endforeach;
            endif;
            ?>


        </table>

        <H3 ALIGN="center"><FONT FACE="Tahoma" SIZE="2" COLOR="BLACK"> Vencimento da 1ª Prestação em: ____/____/_____</FONT></H3> 


        <table class="tabela4">


            <tr>
                <td>Assinatura do Titular:</td>
                <td><p style="margin-left: 25px;">Data Atual</p></td>
                <td>Responsável legal pela Pax el shaday:</td>

            </tr>


            <tr>
                <td>____________________</td>
                <td>____/____/_____</td>
                <td>________________________________</td>
            </tr>
        </table>
<!---

-->
       
    </page>
    
 <script type="text/javascript">

        var visibilidade = true; //Variável que vai manipular o botão Exibir/ocultar


        function ocultardiv() { // Quando clicar no botão.

            if (visibilidade) {//Se a variável visibilidade for igual a true, então...
                document.getElementById("menu").style.display = "none";//Ocultamos a div
                document.getElementById("botoes").style.display = "none";//Ocultamos a div
                //criar um redirecionamento apos criar a pagina para o inicio do sistema . 
                visibilidade = false;//alteramos o valor da variável para falso.
                window.print();

// DEVO CRIAR UMA CONDIÇÃO PARA QUE AO TERMINAR DE IMPRIMIR O DOCUMENTO 
//GERE UMA PERGUNTA SE DESEJA IMPRIMIR OUTRO CONTRATO OU NÃO . 
                 setTimeout(function () {
                if (confirm('Deseja imprimir outro Pedido de Inscrição  ? \n Se SIM clique em OK Se NÃO clique em Cancelar')){
                    location.href="painel.php?exe=pedido_de_inscricao/index";
                  
                }else
                    
                    window.location.href = "painel.php";
                   
                }, 3000);
            } else{
                
            }
        }
    </script>
</body>
</html>
