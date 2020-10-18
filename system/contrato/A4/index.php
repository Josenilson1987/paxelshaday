
<?php
$cpf_titular = filter_input(INPUT_GET, 'cpf_titular', FILTER_DEFAULT);


$ReadTitular = new Read;
$ReadTitular->ExeRead("clientes", "WHERE cpf_titular='$cpf_titular'");


if (!$ReadTitular->getResult()):

    var_dump($ReadTitular);

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
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0,0,0,0.8);
                font-size:11px;
                border:solid #000 2px;
                margin-top: -60px;

            }


            page[size="A4"] {  
                width: 22cm;
                height: 29.7cm; 
                

            }
            page[size="A4"][layout="portrait"] {
                width: 29.7cm;
                height: 21cm;  
            }

            .caixa_de_texto{ 
                padding: 10px 5px 10px 5px; 

                margin: 10px 10px 10px 5px; 

                width: 780px; 

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

            /*ESTILO ACIMA DESTINADO A FOLHA A4 DA PAGINA*/ 


            /*ESTILO ABAIXO DESTINADO A TABELA */ 

            table {
                border-collapse: separate;
                border-spacing: 0 8px;
                margin-top: -8px;
            }

            td {
                border: 0px solid white;
                border-left-width: 0;
                min-width: 120px;
                height: 18px;
            }

            td:first-child {
                border-left-width: 1px;
            }



        </style>





    </head>

    <body>
       <div id="botoes">

            <input type=button  id="imprimir"  onclick="ocultardiv()" value="imprimir">

        </div>


    <page size="A4">

        <div class="caixa_de_texto">
            <br>
            <img src ="images/Figura2.JPG" style =" width:770px; height:60px;">
            <br> <br>


            CONTRATO   <b> Nº <?= $ReadTitular['clientes_id'] ?>  </b>    GRUPO  <b class="to-uppercase"> ( <?= $ReadTitular['tipo_de_plano'] ?> )</b>
            Pelo presente instrumento particular de contrato de prestação de serviços, 
            de um lado a FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS.Pessoas Jurídicas de direito privado,
            sediada na 1º TV Manoel Lino nº 5 Colinas de Periperi salvador-BA, escrito no CNPJ 30.190.845-58, 
            Insc. Estadual nº 636.393/001-42  neste ato representada pelo A Seu diretor responsável 'IN FINE' 
            doravante denominado simplesmente FUNERARIA PAX ELSHADAY J.P.  COMERCIO  SERVIRÇOS PÓSTUMOS,
            é de outro lado com contratante o senhor SR. (<b class="to-uppercase">  <?= $ReadTitular['titular_nome'] ?>  </b>  ), 
            inscrito no cpf: <b class="to-uppercase">  <?= $ReadTitular['cpf_titular'] ?>  </b>, 
            Objetivado os benefícios da prestação de serviços funerários de acordo com as condições a seguir especificadas,
            têm entre se justo é contratado: <br>

            <b>01</b>- A FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS, organização especializada no atendimento de serviços funerários padronizados obriga-se a presta  ao CONTRATANTE os serviços  enumerados a seguir mediante as condições estabelecidas neste Contrato, sendo os seus beneficiados devidamente inscrito e que compõe as seguintes pessoas: esposo (a) ,  filhas e filhos solteiros,  pai e mãe. 
            <br>

            <table>

                <colgroup>

                    <col  class="coluna1"/>

                    <col class="coluna2"/>

                    <col class="coluna3"/>

                </colgroup>

                <tr>
                    <td> A) URNA MORTUARIA   <handler class="to-uppercase"><?= $ReadTitular['modelo_de_urna'] ?> </handler></td>
                    <td></td>
                    <td>F)  CAFÉ EM  PO P/  O VELÓRIO</td>

                </tr>

                <tr>
                    <td>B) CARTIÇAL DE METAL</td>
                    <td></td>
                    <td>G) AÇUCAR    E  COPO DESCARTÁVEL</td>

                </tr>

                <tr>
                    <td>C) CAPELA ARTIFICIAL</td>
                    <td></td>
                    <td> H) LANCHE  NO VELÓRIO  A NOITE</td>

                </tr>

                <tr>
                    <td>D) CARRO FUNERARIO P/ CEPULTAMENTO</td>
                    <td></td>
                    <td>I) GUIA DE SEPURTAMENTO</td>

                </tr>

                <tr>
                    <td>E) CARRO  FUNERARIO P/ REMOÇÂO </td>
                    <td></td>
                    <td>J) LISTA DE PRESENÇA</td>


                </tr>

            </table>

            <b>02</b> – Fica reservado ao CONTRATANTE o direito de inclusão dos filho nascidos no futuros, uma vez  aprezentado o registro de nascimento do mesmo.
            <br>
            <b>03</b> – Caso o CONTRATANTE seja solteiro (a) poderar incluir quando casar  esposo (a), uma vez apresentada à respectiva certidão de nascimento.
            <br>
            <b>04</b> – Acontencendo o casamento dos filhos na qualidade de dependentes do CONTRATANTE, estes  serão excluídos da categoria de beneficiários de 100% poderão usufruir do beneficio somente com 50% do valor do contrato.
            <br>
            <b>05</b> – O CONTRATANTE que não tiver pai e mãe, poderar incluir sogro é sogra devendo pagar somente uma tacha de 50% (cinqüenta porcento) do valor do contrato.
            <br>
            <b>06</b> – Os benefícios mencionadas na clausula 01 só será prestados após uma carência de NOVENTA dias da data do pagamento da 1º prestação, devendo neste caso o CONTRATANTE, quitar todas as prestações vencidas, ou a vencer prevista na clausula 11, ficando desta forma integralizando o pagamento da TAXA DE MANUTENCAO; prevista na clausula 12 os dependentes do 2º grau poderá dividir o pagamento em 03 (três) parcelas.  
            <br>
            <b>07</b>– O prazo de duração deste instrumento será de 05 (cinco) anos,  a contar da data de sua assinatura e o mesmo será automático e sucessivamente prorrogado por iguais períodos nas condições contratuais vigentes na época e a interesse da  FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS, caso não haja notificação por escrito por parte da CONTRATANTE, propondo a sua rescisão no prazo de trinta dias antes do vencimento estipulado.
            <br>
            <b>08</b>- No caso de rescisão do presente contrato, por parte do CONTRATANTE, antes ou após o vencimento estipulado na cláusula anterior, não lhe caberá pelo que houver uma vez que durante o período em que o mesmo manteve seus pagamento em dias a  FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS,garantiu todos os seus direitos, já previstos em cláusulas anteriores.
            <br>
            <b>09</b> –A  FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS, prestará os serviços mencionados na cláusula 01, em cemitérios de livre escolha do (a) CONTRATANTE localizado dentro de uma área de 70Km, (setenta quilômetros) da cidade de SALVADOR-BA em cemitérios públicos. Caso a familia tenho um cemiterio de sua preferência e este seja privado as custas para o devido ato fúnebre será de responsabilidade da mesma. 
            <br>
            <b>10</b>– Havendo necessidade de transportar o corpo para local situado fora da área de atendimento da FUNERARIA PAX ELSHADAY, o  CONTRATANTE  será cobrado esse transporte acima de 70 Km (setenta quilômetros), em conforme com os preços vigentes ao tempo do óbito, o mesmo acontecendo quando se fizer necessário o transporte de outra localidade para área do atendimento, Após os 70Km o CONTRATANTE  pagará o valor de R$ 1,00 por quilometro rodado.
            <br>
            <b>11</b> – O (a) CONTRATANTE pagará A FUNERARIA PAX ELSHADAY, pelos serviços póstumos ou administração contratual durante 24 (vinte e quatro ) meses,  uma taxa pré- fixada da seguinte forma ( 24 ) meses de R$ <b class="to-uppercase">  <?= $ReadTitular['valor_do_plano'] ?>  </b> reais  inicial  COM REAJUSTE  A  CADA  12   MESES,   O  REAJUSTE   É   DE  4  %   PORCENTO SOBRE O SALÁRIO MININO VIRGENTE FIXADO  por  2   ANOS .
            <br>
            <b>12</b> – Fornalizado o pagamento inicial a FUNERARIA PAX ELSHADAY, cuja finalidade precípua e exclusiva é o de recompensá-la pela administração e despensas do empreendimento não será exigido do CONTRATANTE qualquer prestação antecipada, competindo-lhe tão somente uma contribuição mensal de 3% (três por cento) sobre o salário mínimo vigente na região,destinada à cobertura das despensas com materiais e serviços funerários para o sepultamento dos sócios.
            <br>
            <b>13</b>– Ocorrendo algum reajuste por parte do governo indexadores mencionados na cláusula anterior, sem que a FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS, proceda o reajuste da mensalidade, o fato se constituirá da FUNERARIA PAX ELSHADAY J.P. COMERCIO SERVIRÇOS PÓSTUMOS, não se constituindo em renovação do presente contrato e nem direito adquirido pelo (a) CONTRATANTE.


            <b>14</b> – O CONTRATANTE  só começa a contribuir com a taxa de manutenção após o pagamento da ultima parcela referente ao termino do período informado na clausula 11.
            <br>
            <b>15</b> - O CONTRATANTE  terá o contrato cancelado, independente de qualquer notificação judicial ou extrajudicial sem direito do que já foi pago  nas seguintes hipóteses.
            <table>

                <colgroup>

                    <col  class="coluna1"/>

                    <col class="coluna2"/>

                    <col class="coluna3"/>

                </colgroup>

                <tr>
                    <td> A) - Atrasar 90 (noventa) dias consecutivos o pagamento das iniciais referente á taxa de administração se for o caso. </td>
                    <td></td>


                </tr>

                <tr>
                    <td>B) - Atrasar por 03 (três) meses no pagamento da taxa de manutenção</td>
                    <td></td>


                </tr>

                <tr>
                    <td>C) -Se for comprovada inexatidão das declarações no que se refere a inscrição ou atendimento ao beneficio Único A FUNERARIA PAX ELSHADAY J.P COMERCIO SERVIRÇOS POSTUMOS, deixa bem claro aos beneficiários,  que os parentes de 2º grau pagará o valor de um salário mínimo vigente  por um funeral completo, acompanha cartório, lanche no velório a noite, capela artificial.</td>
                    <td></td>


                </tr>



            </table>


            <b>16</b>  -Se for comprovada inexatidão das declarações no que se refere a inscrição ou atendimento ao beneficio Único A FUNERARIA PAX ELSHADAY J.P COMERCIO SERVIRÇOS POSTUMOS, deixa bem claro aos beneficiários,  que os parentes de 2º grau pagará o valor de um salário mínimo vigente  por um funeral completo, acompanha cartório, lanche no velório a noite, capela artificial.
            <br>
            

        </div>
    </page>

    <br>
    <br>
    <br>


   <page size="A4">
        <div class="caixa_de_texto">
            <br>
            <b>17</b> – A FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS, não se responsabilizará por quaisquer despesas feitas pelo CONTRATANTE a não ser quando A EMPREZA autoriza  por escrito.
            <br>
            <b>18</b> – No caso de atrasos, por parte do CONTRATANTE, superiores a 90 (noventa) dias do pagamento da taxa de manutenção, e caso este instrumento ainda não tenha sido cancelado pela FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS, o mesmo poderá saldar seus débitos que estiverem em atraso, desde que fique sujeito a um novo período de carência previsto na cláusula 06.
            <br>
            <b>19</b> – O presente instrumento é intransferível e permanecerá em nome do seu titular até sua morte sucedendo-lhe de fato e de direito o conjugue ou filho mais velho devendo o sucessor responder pelas obrigações ora assumidas, assistindo-lhes por igual idos os direitos decorrentes deste contrato.
            <br>
            <b>20</b> – Os beneficiários inscritos em mais de um contrato, terão seu atendimento prestado pelo primeiro que for solicitado, não cabendo pelas inscrições qualquer indenização estes mesmos serviços.
            <br>
            <b>21</b> – O CONTRATANTE deverá comunicar a FUNERÁRIA PAX ELSHADAY J.P COMÉRCIO SERVIÇOS PÓSTUMOS, imediatamente o falecimento coberto pelo contrato.
            <br>
            <b>22</b> – Caso o evento se verifique em local distante e fora da área de atendimento da FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS, caberá o direito de:
            <table>

                <colgroup>

                    <col  class="coluna1"/>

                    <col class="coluna2"/>

                    <col class="coluna3"/>

                </colgroup>

                <tr>
                    <td> A) - Receber quitadas todas as prestações restantes do seu contrato se estiver pagamento em dia. </td>
                    <td></td>


                </tr>

                <tr>
                    <td>B) Receber quitadas as contribuições constantes na cláusula 12, até valor máximo do contrato firmado com a FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS.</td>
                    <td></td>


                </tr>

                <tr>
                    <td>C)- O CONTRATANTE obriga-se a apresentar dentro do prazo máximo de 30 (trinta) dias, a contar da data do falecimento, a certidão de óbito, a guia de sepultamento, a fim de se beneficiar desta cláusula.</td>
                    <td></td>


                </tr>



            </table>

            <b>23</b>– O CONTRATANTE obriga-se a manter atualizado junto a FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS, o endereço de sua residência.
            <br>
            <b>24</b>– Os pagamentos serão feitos através de um cobrador da empresa ou no próprio Escritório, dando o direito de validade de 05 (cinco) anos, sendo 60 (sessenta) meses para pagar. O Contribuinte renovará seu Contrato com a Empresa Contratante, depois do vencimento dos 5 anos você confirmar com o mesmo Contrato de nº  <b class="to-uppercase">  <?= $ReadTitular['clientes_id'] ?>  </b>, que será de 3% de um salário mínimo vigente do ano corrente.
            <br>
            <b>25</b>– Para os beneficiários inscritos neste contrato cuja medida de urna mortuária seja superior ao tamanho normal que é de até dois metros, o mesmo ficará sujeito à espera necessária do atendimento com caixão de 1º classe com medida fora do padão comercial caso isso ocorra valores adicionais seram acrecentados .
            <br>
            <b>26</b>– As garantias asseguradas por este contrato serão imediatamente suspensas em caso de calamidades públicas, tais como: cataclismos, catástrofes, guerras civis, terremotos ou qualquer outro motivo advindo de caso fortuito ou de força maior.
            <br>
            <b>27</b> – O CONTRATANTE obriga-se a apresentar sua via de contrato com os últimos 03 meses de comprovantes de pagamentos que houver efetuado, todas as vezes que for solicitar atendimento.
            <br>
            <b>28</b> – Juntamente com o presente contrato deverá ser preenchida uma ficha de inscrição, que constará dados pessoais da CONTRATANTE e a relação de seus dependentes ou beneficiários.
            <br>
            <b>29</b> – O CONTRATANTE, declara estar de acordo com cláusulas acima não se responsabilizando a FUNERÁRIA PAX ELSHADAY J.P. COMÉRCIO SERVIÇOS PÓSTUMOS por quaisquer promessas feitas por seus agentes ou vendedores que não estejam previstas neste contrato.
            <br>
            <b>30</b> – As partes elegem o foro e a comarca de Salvador - Bahia, com renúncia expressa a qualquer outro, por mais privilegiado que seja, para dirimir dúvidas ordinárias do presente contrato.
            <br>
            Obs.: O contratante deverá trazer 02 fofos 3x4, junto com seus dados pessoais.
            <br>
            <br>

            <table style="  margin-left: auto; margin-right: auto; width: 20cm;">



                <tr>
                    <td style="margin-right: 100px;"> --------------------------------------------------------------------</td>

                    <td style="margin-left: 100px;">-----------------------------------------------------------</td>


                </tr>

                <tr>

                    <td>FUNERÁRIA PAX ELSHADAY LTDA</td>

                    <td>CONTRATANTE:</td>


                </tr>
            </table>


            <br>

        </div>

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
