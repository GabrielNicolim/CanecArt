<footer>
    <div class="footer-wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>

    <div class="content">
        <div class="left">
            <a href="<?=URLROOT?>/" data-checked="home" class="btn">Home</a>
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
                    echo '<a href="'.URLROOT.'/public/views/register.php" data-checked="register" class="btn primary">Cadastre-se</a>';
                }
            ?>
        </div>

        <div class="back-to-top">
            <a href="#top">
                Voltar ao topo
            </a>
        </div>

        <div class="right">
            <span>Bianca Oliveira de Camargo - 03</span>
            <span>Carla Julia Franco de Toledo - 04</span>
            <span>Felipe Lima Estevanatto - 06</span>
            <span>Gabriel Gomes Nicolim - 08</span>
            <span>Samuel Sensolo Goldflus - 32</span>
        </div>
    </div>
</footer>