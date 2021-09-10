<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produtos</title>

    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/register.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <!-- <div class="error">ERRO</div> -->
            
            <form action="../app/loginLogic.php" method="POST"> <!-- trocar nome do arquvio de acordo com o que será feito -->
                <div class="top">
                    <h2>Cadastro de Produtos</h2>

                    <a href="../index.html">
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