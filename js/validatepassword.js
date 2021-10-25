// Criado por Sam.
// Adaptado de https://pt.stackoverflow.com/questions/316987/validar-for%C3%A7a-da-senha-no-front-end

document.addEventListener("DOMContentLoaded", () => {

    document.forms[0].onsubmit = (e) => {
       return val(e);
    }
 
    password.oninput = (e) => {
       val(e);
    }

    let cpfInput = window.document.getElementById('cpf'); 

    cpfInput.addEventListener('input', (e) => {
        e.target.value = cpfMask(e.target.value);
    })

    function cpfMask(value) {
        return value
        .replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})/, '$1-$2')
        .replace(/(-\d{2})\d+?$/, '$1')
    }

    function val(e) {
 
        let qtde = 0;
        let v = password.value;
        
        e = e.type == "submit"
        
       // verifica se tem 6 caracteres ou mais
       if(v.match(/.{6,}/))
            qtde++;

       // verifica se tem ao menos uma letra maiúscula
       if(v.match(/[A-Z]{1,}/))
            qtde++;
 
       // verifica de tem ao menus um número
       if(v.match(/[0-9]{1,}/))
            qtde++; 
 
       var validacao = 'Fraca';
       switch (qtde)
       {
            case 2:
                validacao = 'M\u00e9dia'; break;
            case 3:
                validacao = 'Forte'; break;
       }

       document.getElementById('password_level').innerHTML = "<strong>For\u00e7a:&nbsp;</strong>" + validacao;
    }
});

// https://stackoverflow.com/questions/948172/password-strength-meter