<?php $userlogin = $_SESSION['usuario_login'];  ?>

<div class="content home">

    <aside>
        <h1 class="boxtitle">Estatísticas de Acesso:</h1>

        <article class="sitecontent boxaside">
            <h1 class="boxsubtitle">Conteúdo:</h1>
            <ul>
                <li class="view"><span>Usuario:</span> <?php echo $userlogin["usuario_nome"]." ".$userlogin["usuario_sobrenome"]?></li>
                <li class="user"><span>Nivel de Acesso</span>  <?php echo $userlogin["usuario_nivel"]?></li>
                <li class="emp"><span>Empresa</span>  <?php echo $userlogin["empresa"]?></li>
                <li class="emp"><span>Cnpj</span>  <?php echo $userlogin["empresa_cnpj"]?></li>

            </ul>
            <div class="clear"></div>
        </article>

       
    </aside>

    <section class="content_statistics">

        <h1 class="boxtitle">Publicações:</h1>

        <section>
            <h1 class="boxsubtitle">Aniversariantes do Mês:</h1>

            <?php for ($i = 1; $i <= 2; $i++): ?>
                <article<?php if ($i % 2 == 0) echo ' class="right"'; ?>>

                    <div class="img thumb_small"></div>
                   
                    </ul>

                </article>
            <?php endfor; ?>
        </section>          


                               

    </section> <!-- Estatísticas -->

    <div class="clear"></div>
</div> <!-- content home -->