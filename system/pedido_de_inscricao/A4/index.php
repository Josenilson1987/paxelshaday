<?php
$cpf_titular = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);

$ReadTitular = new read;
$ReadTitular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");

//var_dump($ReadTitular);

if (!$ReadTitular->getResult()) :

else :
    foreach ($ReadTitular->getResult() as $ReadTitular) :

    endforeach;
endif;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/pedido_de_inscricao.css" />
    <script src="js/prefixfree.min.js"></script>





</head>

<body>

    <?php

    $valor_plano1 = '40,00';
    $valor_plano2 = '70,00';
    $valor_plano3 = '90,00';

    $porcentagem;


    if ($ReadTitular['valor_do_plano'] === $valor_plano1) :
        $porcentagem = '4%';
    else :
        $porcentagem = '6%';
    endif;


    ?>


    <page size="A4">

        <div id="botoes">
            <button class="btn btn-outline-success my-2 my-sm-0" onclick="ocultardiv()" type="submit">IMPRIMIR</button>
        </div>
        <br>

        <img src="imagens/Figura1.JPG" style=" width:970px; height:160px;">

        <br><br>

        <table class="tabela_inscricao">


            <tr>
                <td>NOME DO TITULAR.</td>
                <td> <?= strtoupper($ReadTitular["titular_nome"]) ?></td>

                <td>TELEFONE:</td>
                <td><?= $ReadTitular["telefone"] ?></td>

            </tr>
            <tr>
                <td>ENDEREÇO:</td>
                <td><?= strtoupper($ReadTitular["endereco"]) ?></td>
                <td>CEP:</td>
                <td><?= strtoupper($ReadTitular["cep"]) ?></td>

            </tr>

            <tr>
                <td>BAIRRO:</td>
                <td><?= strtoupper($ReadTitular["bairro"]) ?></td>
                <td>ESTADO:</td>
                <td>
                    <?php
                    $readestado = new Read;
                    $readestado->ExeRead("app_estados");

                    if (!$readestado->getResult()) :

                    else :
                        foreach ($readestado->getResult() as $readestado) :
                            if ($ReadTitular["estado"] === $readestado["estado_id"]) :
                                echo ($readestado["estado_uf"]);
                            endif;
                        endforeach;
                    endif;
                    ?>
                </td>
            </tr>

            <tr>
                <td>CIDADE:</td>
                <td>
                    <?php
                    $readCidade = new Read;
                    $readCidade->ExeRead("app_cidades");

                    if (!$readCidade->getResult()) :

                    else :
                        foreach ($readCidade->getResult() as $readCidade) :
                            if ($ReadTitular["cidade"] === $readCidade["cidade_id"]) :
                                echo  $readCidade["cidade_nome"];
                            endif;
                        endforeach;
                    endif;
                    ?></td>
                <td>NATURALIDADE:</td>
                <td> <?= strtoupper($ReadTitular["naturalidade"]) ?></td>

            </tr>



            <tr>
                <td>VALOR DA ENTRADA:</td>
                <td> <?= $ReadTitular["valor_do_plano"] ?></td>
                <td>mais (11) parcelas de R$:</td>
                <td> <?= $ReadTitular["valor_do_plano"] ?></td>
            </tr>




        </table>


        <br>

        <table class="tabela_inscricao">


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

        <p>
            <H4 ALIGN="justify">
                <FONT FACE="Arial" SIZE="3,0" COLOR="red"> Apos dois anos de contrato, passando se 24 meses a parir da data
                    do primeiro vencimento, e não utilizados dos serviços funerais contratados, o contribuinte poderá anular
                    o mesmo não tendo nenhuma custa, se durante este período os serviços forem utilizados, o contribuinte se
                    responsabiliza a pagar o contrato ate o termino do prazo mínimo estipulado de 24 meses .Caso havendo
                    interesse de continuar com o contrato apos a conclusão dos 24 meses o contribuinte pagara uma taxa de
                    manutenção de <?= $porcentagem ?> ao ano em cima do salário mínimo vigente .</FONT>
            </H4>
        </p>
        <p>
            <H3 ALIGN="justify">
                <FONT FACE="Arial" SIZE="2,9" COLOR="BLACK" class=""><b>Atenção: Caso o beneficiado sendo ele titular ou
                        dependente, venha a óbito em um ambiente famíliar não sendo um hospítal e não tendo acompanhamento
                        médico, o tramite legal sera acionar o IML Institulo Médico Legal,
                        <FONT FACE="Arial" SIZE="2,9" COLOR="red" class=""> <b>a funeraria pax el shaday não forcnece atestado médico.</b></FONT>
                    </b></FONT>
            </H3>
        </p>

        <table class="tabela_inscricao">
            <tr style="background-color: aquamarine;">
                <td style="text-align: center;"><b> BENEFICIÁRIOS E DEPENDENTES</b></td>
            </tr>
        </table>

        <table class="table table-striped">

            <thead>

                <th>Nome:</th>
                <th>RG:</th>
                <th>CPF:</th>
                <th>Data Nascimento:</th>
                <th>Grau De Parentesco:</th>



            </thead>

            <?php
            // REALIZA UMA CONSULTA NA TABELA DEPENDENTES E RETORNO O CPF DO TITULAR
            extract($ReadTitular);
            $ReadTitular["cpf_titular"] = $cpf_titular;

            $listardependentes = new Read;

            $listardependentes->ExeRead("dependentes", "WHERE titular_cpf='$cpf_titular'");



            if (!$listardependentes->getResult()) :
                WSErro("Não exite dependentes cadastrados com este titular ", WS_INFOR);
            else :

                foreach ($listardependentes->getResult() as $listardependentes) :
            ?>
                    <tr class="to-uppercase">

                        <td><?= $listardependentes["dependente_nome"]; ?></td>
                        <td><?= $listardependentes["dependente_rg"]; ?></td>
                        <td><?= $listardependentes["dependente_cpf"]; ?></td>
                        <td><?= $listardependentes["dependente_data_nascimento"]; ?></td>
                        <td><?= $listardependentes["dependente_grau_de_parentesco"]; ?></td>




                    </tr>

            <?php
                endforeach;
            endif;
            ?>


        </table>

        <br>
    <!------
        <H3 ALIGN="right">
            <FONT FACE="Tahoma" SIZE="2" COLOR="BLACK"> Vencimento da 1ª Prestação em: ____/____/_____</FONT>
        </H3>
    ------->        
        <br><br>
        <table class="tabela_inscricao">


            <tr>
                <td style="text-align: center; width: 35%;">Assinatura do Titular:</td>
                <td>
                    <p style="text-align: center;   ">Data Atual</p>
                </td>
                <td style="text-align: center; width: 35%;">Responsável legal pela Pax el shaday:</td>

            </tr>


            <tr>
                <td></td>
                <td style="text-align: center;">________/______/_______</td>
                <td></td>
            </tr>
        </table>


    </page>

    <script type="text/javascript">
        var visibilidade = true; //Variável que vai manipular o botão Exibir/ocultar


        function ocultardiv() { // Quando clicar no botão.

            if (visibilidade) { //Se a variável visibilidade for igual a true, então...
                document.getElementById("menu").style.display = "none"; //Ocultamos a div
                document.getElementById("botoes").style.display = "none"; //Ocultamos a div
                //criar um redirecionamento apos criar a pagina para o inicio do sistema . 
                visibilidade = false; //alteramos o valor da variável para falso.
                window.print();

                // DEVO CRIAR UMA CONDIÇÃO PARA QUE AO TERMINAR DE IMPRIMIR O DOCUMENTO 
                //GERE UMA PERGUNTA SE DESEJA IMPRIMIR OUTRO CONTRATO OU NÃO . 
                setTimeout(function() {
                    if (confirm(
                            'Deseja imprimir outro Pedido de Inscrição  ? \n Se SIM clique em OK Se NÃO clique em Cancelar'
                        )) {
                        location.href = "painel.php?exe=pedido_de_inscricao/index";

                    } else

                        window.location.href = "painel.php";

                }, 3000);
            } else {

            }
        }
    </script>
</body>

</html>