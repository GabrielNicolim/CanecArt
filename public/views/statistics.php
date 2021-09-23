<?php

    session_start();

    $page_title = 'Estatísticas';
    $icon_folder = '../images/logos/favicon.png';

    $style_scripts = ['<link rel="stylesheet" href="../css/style.css">',
                    '<link rel="stylesheet" href="../css/cart.css">'];

    require("../includes/head.php");
    require("../../app/db/env.php");

?>

    <div class="container">
    
        <?php

            include("../includes/header.php");

        ?>

        <section>

            <h1>Estatísticas</h1>

        </section>
    </div>

    <?php

        include("../includes/footer.php");

    ?>

</body>
</html>