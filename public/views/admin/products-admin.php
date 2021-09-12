<?php

    session_start();

    $page_title = 'Produtos - Admin';
    $style_sheets = ['../../css/style.css', 
                     '../../css/admin.css'];
    $icon_folder = '../../images/logos/favicon.png';

    require("../../includes/head.php");

?>
    <div class="container">
        <header id="top">
            <div class="content">
                <a href="home-admin.html" class="logo">
                    Administrador
                </a>
        
                <nav>
                    <a href="home-admin.html" class="btn">Home</a>
                    <a href="products-admin.html" class="btn active">Produtos</a>
                    <a href="#person-admin" class="btn">Pessoas</a>
                    <a href="#Estatics-admin" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

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
                    <input type="number" name="min_value_product" id="min_value_product" placeholder="min">
                    <input type="number" name="max_value_product" id="max_value_product" placeholder="max">
                </div>

                <input type="submit" value="Buscar">
            </form>
        </section>
        
        <section class="list">
            <div class="list-item">
                <img src="../../images/card1-image.png" alt="" class="list-item-image">

                <span class="list-item-name">Caneca Caneca Caneca Caneca Caneca Caneca</span>

                <div class="list-item-buttons">
                    <a href="#" class="btn">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="list-item">
                <img src="../../images/card1-image.png" alt="" class="list-item-image">

                <span class="list-item-name">Caneca Caneca Caneca Caneca Caneca Caneca</span>

                <div class="list-item-buttons">
                    <a href="#" class="btn">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="list-item">
                <img src="../../images/card1-image.png" alt="" class="list-item-image">

                <span class="list-item-name">Caneca Caneca Caneca Caneca Caneca Caneca</span>

                <div class="list-item-buttons">
                    <a href="#" class="btn">
                        <img src="../../icons/eye-fill.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/pencil-square.svg" alt="">
                    </a>
                    <a href="#" class="btn">
                        <img src="../../icons/trash-fill.svg" alt="">
                    </a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>