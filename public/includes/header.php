<header id="top">
    <div class="content">
        <a href="<?=URLROOT?>" class="logo">
            Canec<span>Art</span>
        </a>

        <nav>
            <a href="<?=URLROOT?>" data-checked="home" class="btn">Home</a>
            <a href="<?=URLROOT?>/public/views/products.php" data-checked="products" class="btn">Produtos</a>
            <a href="<?=URLROOT?>/public/views/development.php" data-checked="development" class="btn">Desenvolvimento</a>
            <?php
                if (isset($_SESSION['isAuth'])) {
                    if ($_SESSION['idUser'] < 0) {
                        echo '<a href="'.URLROOT.'/public/views/admin/home-admin.php" data-checked="register" class="btn primary">Perfil</a>';
                    } else {
                        echo '<a href="'.URLROOT.'/public/views/user.php" data-checked="register" class="btn primary">Perfil</a>';
                    }
                } else {
                    echo '<a href="'.URLROOT.'/public/views/login.php" data-checked="register" class="btn primary">Faça Login</a>';
                } 
            ?>
        </nav> 
    </div> 
</header>