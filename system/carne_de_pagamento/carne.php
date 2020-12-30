
<?php

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


var_dump($data);

$nome_empresa = "PAX-EL-SHADAY";
$endereco_empresa = null;
$tel_empresa = null;
$logo = null ;
$qtd = 12;
$ano_vence = $data['ano_inscricao'];
$primeiro_ano = $data['ano_inicial'];
$mes_vence = $data['mes_inicial'];
$primeiro_mes = $data['mes_inicial'];

if ($data['mes_inicial'] == 'janeiro'){
  $primeiro_mes = 1;
}if ($data['mes_inicial'] == 'fevereiro'){
  $primeiro_mes = 2;
}if ($data['mes_inicial'] == 'março'){
  $primeiro_mes = 3;
}if ($data['mes_inicial'] == 'abril'){
  $primeiro_mes = 4;
}if ($data['mes_inicial'] == 'maio'){
  $primeiro_mes = 5;
}if ($data['mes_inicial'] == 'junho'){
  $primeiro_mes = 6;
}if ($data['mes_inicial'] == 'julho'){
  $primeiro_mes = 7;
}if ($data['mes_inicial'] == 'agosto'){
  $primeiro_mes = 8;
}if ($data['mes_inicial'] == 'setembro'){
  $primeiro_mes = 9;
}if ($data['mes_inicial'] == 'outubro'){
  $primeiro_mes = 10;
}if ($data['mes_inicial'] == 'novembro'){
  $primeiro_mes = 11;
}if ($data['mes_inicial'] == 'dezembro'){
  $primeiro_mes = 12;
}



if (!$_POST['titular_nome']) { $nome = ""; } else { $nome = addslashes($_POST['titular_nome']); }


if (!$_POST['numero_ficha']) { $cpf = ""; } else { $cpf = addslashes($_POST['numero_ficha']); }

if (!$_POST['valor_parcela']) { $valor = ""; } else { $valor = addslashes($_POST['valor_parcela']); }





$hoje = date("d/m/Y");

if ($qtd > 212) { header("Location: index.php?error=qtd_limite"); }
?>
<!DOCTYPE HTML>
<!-- SPACES 2 -->
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="Resource-type" content="document">
    <meta name="Robots" content="all">
    <meta name="Rating" content="general">
    <meta name="author" content="Gabriel Masson">
    <title>Carnê</title>
    <link href="img/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div class="bto">
    Ao Imprimir o carnê certifique-se se a impressão está ajustada à página
    <br>
    <br>
    <button class="btn-impress" onclick="window.print()">Imprimir</button>
    &nbsp;
    <?php echo "<a href=\"capa.php?endereco={$endereco_empresa}&tel={$tel_empresa}&logo={$logo}\" class=\"btn\" target=\"_blank\">
      Capa do carnê
    </a>"; ?>
    &nbsp;
    <button class="btn" onclick="window.history.back()">Voltar ao formulário</button>
  </div>

<?php

$count = 1;
$ano_vence = $primeiro_ano;
$mes_vence = $primeiro_mes - 1;

while ($count <= $qtd) {

  if ($mes_vence == 12) { 
    $ano_vence = $ano_vence + 1;
    $mes_vence = 1;
  } else {
    $mes_vence++;
  }

  echo "<!-- PARCELA -->
  <div class=\"parcela\">
    <div class=\"grid\">
      <div class=\"col4\">
        <div class=\"destaca\">
          <table width=\"100%\">
            <tr>
              <td>
                <small>Parcela</small>
                <br>{$count} / {$qtd}
              </td>
            <td>
              <small>Valor</small>
              <br>{$valor}
            </td>
            </tr>
            <tr>
              <td colspan=\"2\">
                <small>Vencimento</small>
                <br>{}/{}/{}
              </td>
            </tr>
            <tr>
              <td colspan=\"2\">
                <small>Observações</small>
                <br><br><br><br>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class=\"col8\">
        <table width=\"100%\">
          <tr>
            <td colspan=\"2\">
              <small>Nome do cedente</small>
              <br>{$nome_empresa}
            </td>
            <td>
              <small>Parcela</small>
              <br>{$count} / {$qtd}
            </td>
            <td>
              <small>Valor</small>
              <br>{$valor}
            </td>
          </tr>
          <tr>
            <td>
              <small>Data do Documento</small>
              <br>{$hoje}
            </td>
            <td>
              <small>Tipo de Documento</small>
              <br>Carnê
            </td>
            <td colspan=\"2\">
              <small>Vencimento</small>
              <br>{}/{}/{}
            </td>
          </tr>
          <tr>
            <td colspan=\"4\">
              <small>Todas as informações deste carnê são de responsabilidade do cedente</small>
              <br>{}
            </td>
          </tr>
        </table>
        <div class=\"nome\">{}, {}, {}</div>
      </div>
    </div>
  </div>";

  

  $count++;
}

?>

  </body>
</html>