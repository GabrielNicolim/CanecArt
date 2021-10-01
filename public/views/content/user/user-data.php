<div class="top-menu">
    <a href="?page=data" class="btn activated">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=adresses" class="btn">Endereços</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">
    <h2>Dados do Usuário</h2>
    
    <h1>Olá <?php echo $return['name_user'] ?>!</h1>

    <p>Você já realizou <?=$return['count']?> pedido(s), obrigado :D</p>

    <form>
        <label for="email-user">Meu Email</label>
        <input type="text" name="email-user" id="email-user" value="<?php echo $return['email_user'] ?>" disabled>

        <label for="cpf-user">Meu CPF</label>
        <input type="text" name="cpf-user" id="cpf-user" value="<?php echo $return['cpf_user'] ?>" disabled>
    </form>
    
    <a href="../../app/logout.php" class="btn logout">Logout</a>
</div>