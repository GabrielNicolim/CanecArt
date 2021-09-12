<?php
    session_start();

    $page_title = 'Inserir produtos';
    $style_sheets = ['../css/style.css', 
                     '../css/register.css'];

    $javascript = ['https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous'];
    $icon_folder = '../images/logos/favicon.png';

    require("../includes/head.php");

?>

    <div class="container">
        <div class="content">
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="error">Dados inválidos!</div>';
                }
            ?>
            
            <form action="../app/insertProducts.php" method="POST"> <!-- trocar nome do arquvio de acordo com o que será feito -->
                <div class="top">
                    <h2>Cadastro de Produtos</h2>

                    <a href="../index.php">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <label for="name_product">Nome</label>
                <input type="text" name="name_product" id="name_product" required="required">

                <label for="description_produtc">Descrição</label>
                <input type="text" name="description_produtc" id="description_produtc" required="required">  <!-- produTC ao invés de produCT na tabela -->
                
                <label for="price_product">Preço</label>
                <input type="text" name="price_product" id="price_product">
                
                <label for="type_product">Tipo</label>
                <input type="text" name="type_product" id="type_product">
                
                <label for="quantity_product">Quantidade</label>
                <input type="number" min="1" max="500" name="quantity_product" id="quantity_product">
            
                <input type="submit" value="Enviar">
            </form>

            <a href="register.php">
                Ainda não possui cadastro? Cadastre-se!
            </a>
        </div>
    </div>
</body>
</html>