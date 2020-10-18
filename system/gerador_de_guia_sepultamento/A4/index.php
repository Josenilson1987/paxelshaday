
<?php
$cpf_responsavel = filter_input(INPUT_GET, 'cpf_responsavel', FILTER_DEFAULT);

$ReadGuia = new read;
$ReadGuia->ExeRead("guia_de_sepultamento", "WHERE cpf_responsavel='$cpf_responsavel'");


if (!$ReadGuia->getResult()):

else:
    foreach ($ReadGuia->getResult() as $GerarGuia):

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
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
                font-size: 15px;
                border:solid #000 3px;

            }

            h4{

                align-left: 5px; 

            }
            page[size="A4"] {  
                width: 21cm;
                height: 29.7cm; 
            }
            page[size="A4"][layout="portrait"] {
                width: 29.7cm;
                height: 21cm;  
            }

            @media print {
                body, page {
                    margin: 0;
                    box-shadow: 0;
                }
            }
        </style>

        <!--ESTILO DESTINADO A FOLHA A4 DA PAGINA -->



    </head>

    <body>

    <page size="A4">

        <br>
        <img src ="images/Figura1.JPG" style =" width:770px; height:70px;">
        <legend style="text-align: left; font-size: 20px; color: blue;">Informações do Responsável (a):</legend>
       
        <table class="tabela1">


            <tr>
                <td>Nome: <?= strtoupper($GerarGuia["nome_responsavel"]) ?></td>
                <td>CPF: <?= strtoupper($GerarGuia["cpf_responsavel"]) ?></td>
            </tr>
            <tr>
                <td>Telefone: <?= strtoupper($GerarGuia["telefone_responsavel"]) ?></td>
                <td>Endereço: <?= strtoupper($GerarGuia["endereco_responsavel"]) ?></td>
            </tr>

            <tr>
                <td>Nº: <?= strtoupper($GerarGuia["n_responsavel"]) ?></td>
                <td>Bairro: <?= strtoupper($GerarGuia["bairro_responsavel"]) ?></td>
            </tr>

            <tr>
                <td>Cep: <?= strtoupper($GerarGuia["cep_responsavel"]) ?></td>
               <td>Gual de parentesco: <?= strtoupper($GerarGuia["parentesco_responsavel"]) ?></td>
            </tr>

           

        </table>


      
        <table class="tabela2">   
            <tr>
                <td style="">BENEFICIÁRIOS E DEPENDENTES</td>
            </tr>
        </table>

         <table class="tabela3">


            <tr>
                <td>Cart. Identidade (RG): <?= strtoupper($GerarGuia["nome_responsavel"]) ?></td>
                <td>CPF: <?= strtoupper($GerarGuia["cpf_responsavel"]) ?></td>
            </tr>
            <tr>
                <td>Profissão: <?= strtoupper($GerarGuia["telefone_responsavel"]) ?></td>
                <td>Nacionalidade: <?= strtoupper($GerarGuia["endereco_responsavel"]) ?></td>
            </tr>

            <tr>
                <td>Estado Civil: <?= strtoupper($GerarGuia["n_responsavel"]) ?></td>
                <td>Plano: <?= strtoupper($GerarGuia["bairro_responsavel"]) ?></td>
            </tr>

            <tr>
                <td>Estado Civil: <?= strtoupper($GerarGuia["cep_responsavel"]) ?></td>
               <td>Estado Civil: <?= strtoupper($GerarGuia["parentesco_responsavel"]) ?></td>
            </tr>

           

        </table>
<!---
GERA A DATA ATUAL NO FINAL DO DOCUMENTO 
 <?php echo date("d-m-Y") ?>
-->
       
    </page>
</body>
</html>
