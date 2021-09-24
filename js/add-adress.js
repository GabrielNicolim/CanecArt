function my_callback(conteudo) {
    if (!("erro" in conteudo)) {
        console.log(conteudo);
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


// Button to show form 

const btn = window.document.querySelector('#add-adress');
const form = window.document.getElementById('form-adress');

btn.addEventListener('click', () => {
    if(form.classList.contains('visible')) {
        form.classList.remove('visible');
        btn.innerHTML = '<i class="fas fa-plus"></i> Adicionar Endereço';
    } else {
        form.classList.add('visible');
        btn.innerHTML = '<i class="fas fa-minus"></i> Esconder formulário';
    }
});
