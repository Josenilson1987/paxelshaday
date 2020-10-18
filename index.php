<?php
session_start();
require"_app/Config.inc.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">

        <title>Site Admin</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="_app/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />

        <script src="js/jquery.js"></script>
      
        <script src="js/script.js"></script>




    </head>
    <body class="login">

        <div id="login">
            <div class="boxin">

<!--                <h1><img src="images/bliblia.jpg" alt="login" /></h1>-->

                <h2>SIS FUNERÁRIA</h2>

                <?php
                $login = new Login(1, 1);
                


                if ($login->CheckLogin()):
                    header('Location: painel.php');
                endif;

                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dataLogin['AdminLogin'])):
                    // echo para visualizar a senha criptografada md5 
                    // echo md5 ($dataLogin['pass']);
                    
                    
                    
                    $login->ExeLogin($dataLogin);
                    if (!$login->getResult()):
                        WSErro($login->getError()[0], $login->getError()[1]);
                    else:
                     
                        header('Location: painel.php');
                    endif;

                endif;

                $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                if (!empty($get)):
                    if ($get == 'restrito'):
                        WSErro('<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!', WS_ALERT);
                    elseif ($get == 'logoff'):
                        WSErro('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', WS_ACCEPT);
                    endif;
                endif;
                ?>

                <form name="AdminLoginForm" action="" method="post">
                    <label>
                        <span>E-mail:</span>
                        <input type="text" name="user" />
                    </label>

                    <label>
                        <span>Senha:</span>
                        <input type="password" name="pass" />
                    </label>  

                    <button  type="submit" name="AdminLogin" value="Logar" class="btn blue" >Logar</button>
<!--                   <img class="" src="images//load.gif" alt="[CARREGANDO...]" title="CARREGANDO..."/>-->
                   
                </form>



            </div>
        </div>

    </body>
</html>