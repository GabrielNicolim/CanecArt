<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=config" class="btn activated">Configurações</a>
</div>

<div class="content">
    <h2>Alterar Dados do Usuário</h2>  

    <form action="">
        <label for="name">Nome</label>
        <input type="text" name="anem" id="name" value="<?=$name_user?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?=$email_user?>">

        <input type="submit" value="Alterar Dados">
    </form>
</div>