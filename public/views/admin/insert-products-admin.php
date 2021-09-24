<?php
    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Inserir produtos';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>',
                    '<script src="../../../js/admin.js"></script>',         
                    '<link rel="stylesheet" href="../../css/style.css">',
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

                <label for="name_product">Nome</label>
                <input type="text" name="name_product" id="name_product" required="required">

                <label for="photo_product">Foto</label>
                <input type="file" name="photo_product" id="photo_upload" accept="image/png, image/jpeg, image/jpg"  
                onchange="loadFile(event)">
                <img id="preview_output" width="100%"/>

                <label for="description_produtc">Descrição</label>
                <textarea name="description_product" id="description_product" cols="30" rows="5"></textarea>
                
                <label for="price_product">Preço</label>
                <input type="number" name="price_product" min="0" step="0.01" max="999999" id="price_product" required>
                
                <label for="type_product">Tipo</label>
                <input type="text" name="type_product" id="type_product" required>
                
                <label for="quantity_product">Quantidade</label>
                <input type="number" min="1" step="1" max="500" name="quantity_product" id="quantity_product">
            
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>
</html>