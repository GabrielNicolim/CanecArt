<div class="top-menu">
    <a href="?page=data" class="btn">Perfil</a>
    <a href="?page=orders" class="btn">Pedidos</a>
    <a href="?page=adresses" class="btn activated">Endereços</a>
    <a href="?page=config" class="btn">Configurações</a>
</div>

<div class="content">
    <h2>Endereços</h2>

    <button>Adicionar Endereço</button>

    <form action="../../../app/changeUserData.php" method="post">
        <label for="name">Nome do contato</label>
        <input type="text" name="name" id="name">

        <label for="CEP">CEP</label>
        <input type="text" name="CEP" id="CEP" value="" size="10" maxlength="9"
               onblur="searchcep(this.value);">

        <label for="street">Rua</label>
        <input type="text" name="street" id="street" required>
        
        <label for="district">Bairro</label>
        <input type="text" name="district" id="district" required>

        <label for="city">Cidade</label>
        <input type="text" name="city" id="city" required>

        <label for="state">Estado</label>
        <input type="text" name="state" id="state" required>

        <label for="number">Numero</label>
        <input type="text" name="number" id="number" required>

        <label for="complement">Complemento</label>
        <input type="text" name="complement" id="complement">

        <input type="submit" value="Adicionar endereço">
    </form>
</div>

<script>
    function my_callback(conteudo) {
        if (!("erro" in conteudo)) {
            // Update the fields with the values given.
            document.getElementById('street').value=(conteudo.logradouro);
            document.getElementById('district').value=(conteudo.bairro);
            document.getElementById('city').value=(conteudo.localidade);
            document.getElementById('state').value=(conteudo.uf);
        }
    }
        
    function searchcep(valor) {
        // New variable "cep" with only digits.
        var cep = valor.replace(/\D/g, '');

        // Verify if field is not empty now.
        if (cep != "") {

            // Regex to validate CEP.
            var validacep = /^[0-9]{8}$/;

            // Validate CEP format.
            if(validacep.test(cep)) {
                console.log(cep);
                // Fill the fields with "..." while waiting for webservice.
                document.getElementById('street').value="...";
                document.getElementById('district').value="...";
                document.getElementById('city').value="...";
                document.getElementById('state').value="...";

                // Creates a javascript element.
                var script = document.createElement('script');

                // Syncs with the callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=my_callback';

                // Insert the script in the document and loads the content.
                document.body.appendChild(script);

            } //end if.

        } //end if.
    };
</script>