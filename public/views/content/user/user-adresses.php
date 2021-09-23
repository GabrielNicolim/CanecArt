<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=adresses" class="btn activated">Endereços</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">
    <h2>Endereços</h2>

    <div class="adresses">
        <div class="adress_box">
            <div class="adress_top">
            <i class="fas fa-address-book"></i>
            Samuel S. Goldflus
            </div>
            <div class="adress_body">
                CEP: 782232, Penápolis, RJ<br>
                Bairro Mario Sergio, Rua João Augusto Fischer
                Numero 2-45, gordura <br>
            </div>
            <div class="footer">
                <a href="#"><i class="fas fa-trash-alt"></i>Excluir</a>
            </div>
        </div>
    </div>

    <button id="add-adress">
        <i class="fas fa-plus"></i>
        <span>Adicionar Endereço</span>
    </button>

    <form id="form-adress" action="../../../app/changeUserData.php" method="post">
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