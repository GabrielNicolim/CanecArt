<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Produtos - Admin';
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
                    <a href="products-admin.php" class="btn active">Produtos</a>
                    <a href="peoples-admin.php" class="btn">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <!--Produtos-->
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
                    <span>Preço:</span>
                    <input type="range" id="rangeInput" name="rangeInput" value="35" min="0" max="100" oninput="document.getElementById('textInput').value=this.value;">
                    <input type="numeric" step="0.01" id="textInput" value="35" min="0" max="100" oninput="document.getElementById('rangeInput').value=this.value;" onkeydown="return event.key != 'Enter';">
                </div>

                <input type="submit" value="Buscar">
            </form>

            <a href="insert-products-admin.php" class="btn insert">Inserir Produto</a>
        </section>
        
        <section class="list">
            <div class="list-info">
                <div class="list-name">Nome</div>
                <div class="list-avalible">Estoque</div>
                <div class="list-type">Tipo</div>
                <div class="list-price">Preço</div>
                <div class="list-interaction">Interação</div>
            </div>

            <!--Content of table-->
            <?php

                require("../../../app/db/connect.php");

                $query = "SELECT id_product, name_product, photo_product, price_product, type_product, quantity_product FROM products";
                $stmt = $conn->prepare($query);
                $stmt -> execute();

                $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                if ($stmt -> rowCount() == 0) {
                    echo '<div class="list-item"><div class="list-name">Nenhum produto cadastrado!</div></div>';
                } else {
                    foreach ($return as $product) {
                        echo '
                        <div class="list-item" id="'.$product['id_product'].'">
                            <img class="image" src="../../images/';
                            if (is_null($product['photo_product'])) echo 'missing-image.png'; else echo $product['photo_product'];
                            echo '" alt="">
                            <div class="list-name">'.$product['name_product'].'</div>
                            <div class="list-avalible>'.$product['quantity_product'].'</div>
                            <div class="list-type">'.$product['type_product'].'</div>
                            <div class="list-price">'.$product['price_product'].'</div>
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
                        ';
                    }
                }
                
            ?>
        </section>
    </div>
</body>
</html>