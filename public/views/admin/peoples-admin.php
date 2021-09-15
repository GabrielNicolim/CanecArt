<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Pessoas - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../../css/style.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">'];

    require("../../includes/head.php");

?>
    <div class="container">
        <!--Header-->
        <header id="top">
            <div class="content">
                <a href="home-admin.php" class="logo">
                    Administrador
                </a>
        
                <nav>
                    <a href="home-admin.php" class="btn">Home</a>
                    <a href="products-admin.php" class="btn">Produtos</a>
                    <a href="peoples-admin.php" class="btn active">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <!--Pessoas-->
        <section class="search">
            <form action="" method="GET">
                <span>Busca:</span>
                <input type="text" name="name_product" id="name_product" placeholder="Nome">
                
                <select name="type_product" id="type_product">
                    <option value="valor1" selected>Tipo</option>
                    <option value="valor2">Valor 1</option>
                    <option value="valor3">Valor 2</option>
                </select>

                <div class="value">
                    <span>Compras:</span>
                    <input type="range" id="rangeInput" name="rangeInput" value="35" min="0" max="100" oninput="document.getElementById('textInput').value=this.value;">
                    <input type="numeric" step="0.01" id="textInput" value="35" min="0" max="100" oninput="document.getElementById('rangeInput').value=this.value;" onkeydown="return event.key != 'Enter';">
                </div>

                <input type="submit" value="Buscar">
            </form>

            <a href="insert-products-admin.php" class="btn insert">Inserir Produto</a>
        </section>
        
        <section class="list">
            <div class="list-info">
                <div class="list-state">Estado</div>
                <div class="list-name">Nome</div>
                <div class="list-email">Email</div>
                <div class="list-price">Quantidade compra</div>
                <div class="list-interaction">Interação</div>
            </div>

            <div class="list-item">
                <div class="list-state">False</div>
                <div class="list-name">Jorge da Nike</div>
                <div class="list-email">jorginhodanike58@gmail.com</div>
                <div class="list-price">12 compras</div>
                <div class="list-interaction">
                    <a href="">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="list-item">
                <div class="list-state">False</div>
                <div class="list-name">Jorge da Nike</div>
                <div class="list-email">jorginhodanike58@gmail.com</div>
                <div class="list-price">12 compras</div>
                <div class="list-interaction">
                    <a href="">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="list-item">
                <div class="list-state">False</div>
                <div class="list-name">Jorge da Nike</div>
                <div class="list-email">jorginhodanike58@gmail.com</div>
                <div class="list-price">12 compras</div>
                <div class="list-interaction">
                    <a href="">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="list-item">
                <div class="list-state">False</div>
                <div class="list-name">Jorge da Nike</div>
                <div class="list-email">jorginhodanike58@gmail.com</div>
                <div class="list-price">12 compras</div>
                <div class="list-interaction">
                    <a href="">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>