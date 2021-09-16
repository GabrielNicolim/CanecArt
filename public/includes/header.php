<header id="top">
    <div class="content">
        <a href="#home" class="logo">
            Canec<span>Art</span>
        </a>

        <nav>
            <a href="../../index.php" data-checked="home" class="btn">Home</a>
            <a href="products.php" data-checked="products" class="btn">Produtos</a>
            <a href="statistics.php" data-checked="estatics" class="btn">Estatísticas</a>
            <a href="development.php" data-checked="development" class="btn">Desenvolvimento</a>
            <?php
                if (isset($_SESSION['isAuth'])) {
                    echo '<a href="user.php" data-checked="register" class="btn primary">Perfil</a>';
                } else {
                    echo '<a href="register.php" data-checked="register" class="btn primary">Cadastre-se</a>';
                }
            ?>
        </nav> 
    </div> 
</header>