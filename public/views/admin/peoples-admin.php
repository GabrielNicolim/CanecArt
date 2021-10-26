<?php

    session_start();

    if (!isset($_SESSION['isAuth']) && $_SESSION['idUser'] != -1) {
        header("Location: ../login.php");
        exit();
    }

    $page_title = 'Pessoas - Admin';
    $icon_folder = '../../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../../css/style.css">',
                    '<link rel="stylesheet" href="../../css/list.css">',
                    '<link rel="stylesheet" href="../../css/admin.css">'];

    require("../../includes/head.php");
    require("../../../app/db/connect.php");
    require("../../../app/functions.php");

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
                    <a href="../statistics.php" class="btn">Estatísticas</a>
                </nav> 
            </div> 
        </header>

        <!--Pessoas-->
        <section class="search">
            <form action="" method="GET">
                <span>Busca:</span>
                <input type="text" name="name_product" id="name_product" placeholder="Nome">
                Incluir Email:<input type="checkbox" name="include_email" id="">

                <select name="type_user" id="type_product">
                    <option value="" disabled selected>Tipo</option>
                    <option value="True">Deletados</option>
                    <option value="False">Ativos</option>
                </select>

                <div class="value">
                    <span>Compras:</span>
                    <input type="range" id="rangeInput" name="rangeInput" value="0" min="0" max="512" oninput="document.getElementById('textInput').value=this.value;">
                    <input type="numeric" step="1" id="textInput" value="0" min="0" max="512" oninput="document.getElementById('rangeInput').value=this.value;" onkeydown="return event.key != 'Enter';">
                </div>

                <input type="submit" value="Buscar">
            </form>

        </section>
        
        <section class="list">
            <!--Header of table-->
            <div class="list-info">
                <div class="list-state">Excluído</div>
                <div class="list-name">Nome</div>
                <div class="list-email">Email</div>
                <div class="list-price">Quantidade compras</div>
                <div class="list-interaction">Interação</div>
            </div>

            <!--Content of table-->
            <?php

                $query = "SELECT id_user, name_user, email_user, deleted, deleted_at, (SELECT COUNT(*) FROM eq3.orders WHERE fk_user = id_user) AS compras 
                        FROM eq3.users
                        WHERE (LOWER(name_user) LIKE :search OR LOWER(email_user) LIKE :search_mail) 
                        AND (SELECT COUNT(*) FROM eq3.orders WHERE fk_user = id_user) >= :orders ";

                $search = '%%';
                $searchMail = '%%';
                if (isset($_GET['name_product'])) { 
                    $search = '%'.strtolower(sanitizeString($_GET['name_product'])).'%';
                    if (isset($_GET['include_email']) && $_GET['include_email'] == 'on') {
                        $searchMail = $search;
                    } else {
                        $searchMail = '';
                    }
                }

                if (isset($_GET['type_user'])) {
                    $typeSearch = sanitizeString($_GET['type_user']);
                    if (!empty($typeSearch)) {
                        if ($typeSearch == 'True') {
                            $query .= ' AND deleted = TRUE';
                        } else {
                            $query .= ' AND deleted = FALSE';
                        }
                    }
                }

                $orders = 0;
                if (isset($_GET['rangeInput'])) {
                    $orders = sanitizeString($_GET['rangeInput']);
                }

                $stmt = $conn->prepare($query);

                $stmt -> bindValue(':search', $search, PDO::PARAM_STR);
                $stmt -> bindValue(':search_mail', $searchMail, PDO::PARAM_STR);
                $stmt -> bindValue(':orders', $orders, PDO::PARAM_INT);

                $stmt -> execute();

                $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                if ($stmt -> rowCount() == 0) {
                    echo '<div class="list-item"><div class="list-name">Nenhum usuário cadastrado!</div></div>';
                } else {
                    foreach ($return as $user) {
                        echo '
                        <div class="list-item '; if($user['deleted']) echo 'item-deleted'; echo '" id="'.$user['id_user'].'">
                            <div class="list-state">'; 
                            if($user['deleted']) {
                                $myDateTime = DateTime::createFromFormat('Y-m-d', $user['deleted_at']);
                                echo 'Sim<br>'.$myDateTime->format('d/m/Y');
                            } else echo 'Não';
                            echo '</div>
                            <div class="list-name">'.ucwords($user['name_user']).'</div>
                            <div class="list-email">'.$user['email_user'].'</div>
                            <div class="list-price">'.$user['compras'].' compras</div>
                            <div class="list-interaction">';
                                if ($user['deleted']) {
                                    echo '<a href="../../../app/deleteUsers.php?delete='.$user['id_user'].'&status=0">
                                        <img src="../../icons/trash-restore-solid.svg" alt="Icone de restaurar">
                                    </a>';
                                } else {
                                    echo '<a href="../../../app/deleteUsers.php?delete='.$user['id_user'].'&status=1" >
                                        <img src="../../icons/trash-fill.svg" alt="Icone de deletar">
                                    </a>';
                                }                            
                                echo'
                            </div>
                        </div>';
                    }
                }
            ?>
        </section>
    </div>
</body>
</html>