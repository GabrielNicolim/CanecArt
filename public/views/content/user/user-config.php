<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=adresses" class="btn">Endereços</a>
    <a href="?page=config" class="btn activated">Configurações</a>
</div>

<div class="content">
    <h2>Alterar Dados do Usuário</h2>  

    <form action="../../../app/changeUserData.php" method="post">
        <label for="name">Nome</label>
        <input type="text" name="anem" id="name" value="<?=$return['name_user']?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?=$return['email_user']?>">

        <label for="cpf">CPF</label>
        <input type="text" value="<?=$return['cpf_user']?>" id="cpf" disabled>

        <input type="submit" value="Alterar Dados">
    </form>

    <a href="../../app/logout.php"><h1>Log out</h1></a>
</div>