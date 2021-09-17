<div class="top-menu">
    <a href="?page=data" class="btn activated">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">
    <h2>Dados do Usuário</h2>   

    <form>
        <label for="name-user">Nome</label>
        <input type="text" name="name-user" id="name-user" value="<?php echo "Gabriel" ?>" disabled>

        <label for="email-user">Email</label>
        <input type="text" name="email-user" id="email-user" value="<?php echo "gabriel.gomes.nicolim@gmail.com" ?>" disabled>

        <label for="cpf-user">CPF</label>
        <input type="text" name="cpf-user" id="cpf-user" value="<?php echo "1111111111111" ?>" disabled>
    </form>
</div>