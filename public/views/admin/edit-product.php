<?php

    session_start();
    require("../../../app/db/connect.php");
    require("../../../app/functions.php");

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Editar produto - Admin';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<script src="../../../js/admin.js"></script>',
                    '<link rel="stylesheet" href="../../css/admin.css">',
                    '<link rel="stylesheet" href="../../css/form.css">'];

    require("../../includes/head.php");

    $id_product = sanitizeString($_GET['product']);

    $query = "SELECT * FROM eq3.products WHERE id_product = :id_product";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue('id_product', $id_product, PDO::PARAM_INT);

    $return = $stmt -> execute();

    if (!$return || $stmt -> rowCount() == 0) {
        header("Location: home-admin.php?error=1");
        exit;
    }

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

?>
    <div class="container">
        <div class="content">
            <form action="../../../app/editProducts.php" method="POST" enctype="multipart/form-data">
                <div class="top">
                    <h2>Editar Produto</h2>
                    <a href="products-admin.php">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </div>
                <input type="hidden" value="<?=$return['id_product']?>" name="id_product">
                <input type="hidden" value="<?=$return['photo_product']?>" name="photo_name">

                <label for="name_product">Nome</label>
                <input type="text" value="<?=$return['name_product']?>" name="name_product" id="name_product" required>

                <label for="photo_product">Foto</label>
                <input type="file" name="photo_product" id="photo_upload" accept="image/png, image/jpeg, image/jpg"
                onchange="loadFile(event)">
                <?php if (!empty($return['photo_product'])) 
                    echo ' <img id="preview_output" width="100%" src="../../images/'.$return['photo_product'].'"/>';
                ?>

                <label for="description_produtc">Descrição</label>
                <textarea name="description_product" id="description_product" cols="30" rows="5" maxlength="512"><?=$return['description_product']?></textarea>
                
                <label for="base_cost_product">Custo base</label>
                <input type="text" min="0" step="0.01" value="<?=$return['base_cost_product']?>" max="100" value="0" name="base_cost_product" id="base_cost_product" onkeyup="updateValue()" required>

                <label for="price_product">Preço consumidor</label>
                <input type="text" name="price_product" value="<?=$return['price_product']?>" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" placeholder="Ex: 25,90" max="999999" id="price_product" onkeyup="updateValue()" required>

                <label for="price_product">Lucro desejado *</label>
                // AEOOOOOOOOOOOOOO
                <input type="text" value="<?= $return ?>"name="price_product" min="0" max="999" id="profit_margin" onkeyup="updateValue()" required>

                <span id="profit">Lucro unidade: R$ 0,00 ou 0,00% do valor final</span>

                <label for="type_product">Tipo</label>
                <input type="text" name="type_product" value="<?=$return['type_product']?>" placeholder="Ex: Pokemon_GO Pikachu" id="type_product" required>
                
                <label for="quantity_product">Quantidade</label>
                <input type="text" value="<?=$return['quantity_product']?>" min="0" step="1" max="500" value="0" name="quantity_product" id="quantity_product">

                <input type="submit" name="operation" value="Atualizar dados">
            </form>
        </div>
    </div>
</body>
</html>