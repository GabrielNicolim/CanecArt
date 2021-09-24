<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=adresses" class="btn activated">Endereços</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">
    <h2>Endereços cadastrados</h2>

    <?php
        if (isset($_GET['error'])) {
            if (!$_GET['error']) {
                echo '<div class="notice">
                    Endereço inserido com sucesso!
                </div>';
            } else {
                echo '<div class="notice">
                    Algo de errado aconteu!
                </div>';
            }
        }
    ?>

    <div class="adresses">
        <?php

            $query = "SELECT * FROM adresses WHERE fk_user = :session_id";

            $stmt = $conn -> prepare($query);
            $stmt -> bindValue(':session_id', $_SESSION['idUser'], PDO::PARAM_INT);
            
            $stmt -> execute();

            $result = $stmt -> fetchALL(PDO::FETCH_ASSOC);

            if ($stmt -> rowCount() == 0)
                echo '<div class="adress_box"><h1>Nenhum endereço cadastrado no momento</h1></div>';
            foreach($result as $adress) {
                echo '<div class="adress_box">
                <div class="adress_top">
                <i class="fas fa-address-book"></i>
                    '.$adress['contact_adress'].'
                </div>
                <div class="adress_body">
                    CEP: '.$adress['cep_adress'].', '.$adress['city_adress'].', '.$adress['state_adress'].'<br>
                    Bairro '.$adress['district_adress'].',<br>
                    '.$adress['street_adress'].',
                    Numero '.$adress['number_adress'].',<br>
                    Complemento: '.$adress['complement_adress'].'
                </div>
                <div class="footer">
                    <a href="../../app/deleteAdresses.php?delete='.$adress['id_adress'].'"><i class="fas fa-trash-alt"></i> Excluir</a>
                </div>
                </div>';
            }

        ?>
    </div>

    <button id="add-adress">
        <i class="fas fa-plus"></i>
        <span>Adicionar Endereço</span>
    </button>

    <form id="form-adress" action="../../app/addAdress.php" method="post" >
        <div class="w-100">
            <label for="name">Nome do contato</label>
            <input type="text" name="name" id="name">
        </div>
       
        <div>
            <label for="CEP">CEP</label>
            <input type="text" name="CEP" id="CEP" value="" size="10" maxlength="9"
                onblur="searchcep(this.value);">
        </div>

        <div>
            <label for="city">Cidade</label>
            <input type="text" name="city" id="city" required>
        </div>

        <div>
            <label for="state">Estado</label>
            <input type="text" name="state" id="state" required>
        </div>

        <div>
            <label for="number">Numero</label>
            <input type="text" name="number" id="number" required>
        </div>

        <div class="w-100">
            <label for="street">Rua</label>
            <input type="text" name="street" id="street" required>
        </div>
        
        <div class="w-100">
            <label for="district">Bairro</label>
            <input type="text" name="district" id="district" required>
        </div>

        <div class="w-100">
            <label for="complement">Complemento</label>
            <input type="text" name="complement" id="complement">
        </div>

        

        <input type="submit" value="Adicionar endereço">
    </form>
</div>

<script src="../../js/add-adress.js"></script>