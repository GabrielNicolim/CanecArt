<?php

    session_start();
    require("../../../app/db/env.php");

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Inserir produtos';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<script src="../../../js/admin.js"></script>',         
                    '<link rel="stylesheet" href="../../css/form.css">'];

    require("../../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="error">Dados inválidos!</div>';
                }
            ?>
            <form action="../../../app/insertProducts.php" method="POST" enctype="multipart/form-data">
                <div class="top">
                    <h2>Cadastrar Produto</h2>

                    <a href="products-admin.php">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </div>

                <label for="name_product">Nome *</label>
                <input type="text" name="name_product" placeholder="Caneca" id="name_product" required>

                <label for="photo_product">Foto</label>
                <input type="file" name="photo_product" id="photo_upload" accept="image/png, image/jpeg, image/jpg"  
                onchange="loadFile(event)">
                <img id="preview_output" width="100%"/>

                <label for="description_produtc">Descrição *</label>
                <textarea name="description_product" id="description_product" cols="30" rows="5" maxlength="512"></textarea>
                
                <label for="base_cost_product">Custo base *</label>
                <input type="text" min="0" step="0.01" max="100" value="0" name="base_cost_product" id="base_cost_product" onkeyup="updateValue()" required>

                <label for="price_product">Lucro desejado (%) *</label>
                <input type="text" name="profit_margin" min="0" max="999" id="profit_margin" onkeyup="updateValue()" required>

                <span id="profit">Lucro unidade: R$ 0,00 ou 0,00% do valor final</span>

                <label for="type_product">Tipo *</label>
                <input type="text" name="type_product" placeholder="Ex: Pokemon_GO Pikachu" id="type_product" required>
                
                <label for="quantity_product">Código Produto *</label>
                <input type="text" maxlength="14" placeholder="Ex: 010.16.00001-1" name="code_product" id="code_product">

                <label for="quantity_product">Quantidade *</label>
                <input type="text" value="0" name="quantity_product" id="quantity_product">
                
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>
</html>