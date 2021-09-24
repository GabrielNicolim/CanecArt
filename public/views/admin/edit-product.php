<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Editar produto - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<link rel="stylesheet" href="../../css/style.css">',
                    '<script src="../../../js/admin.js"></script>',
                    '<link rel="stylesheet" href="../../css/admin.css">',
                    '<link rel="stylesheet" href="../../css/form.css">'];

    require("../../includes/head.php");
    require("../../../app/db/connect.php");
    require("../../../app/functions.php");

    $id_product = sanitizeString($_GET['product']);

    $query = "SELECT * FROM products WHERE id_product = :id_product";

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
                <input type="file" name="photo_product" id="photo_upload" accept="image/png, image/jpeg"
                onchange="loadFile(event)">
                <img id="preview_output" width="100%" src="../../images/<?=$return['photo_product']?>"/>

                <label for="description_produtc">Descrição</label>
                <textarea name="description_product" id="description_product" cols="30" rows="5" required><?=$return['description_product']?></textarea>
                
                <label for="price_product">Preço<?=$return['price_product']?></label>
                <input type="number" value="<?=$return['price_product']?>" min="0" step="0.01" max="999999" name="price_product" id="price_product" required>
                
                <label for="type_product">Tipo</label>
                <input type="text" value="<?=$return['type_product']?>" name="type_product" id="type_product" required>
                
                <label for="quantity_product">Quantidade</label>
                <input type="number" value="<?=$return['quantity_product']?>" min="0" step="1" max="500" name="quantity_product" id="quantity_product" required>
            
                <input type="submit" name="operation" value="Atualizar dados">
            </form>
        </div>
    </div>
</body>
</html>