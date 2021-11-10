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

    if (cpfInput != null) {
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
    }

    function val(e) {
        let qtde = 0;
        let v = password.value;
        let tip = "";
        let out = document.getElementById('password_level');
        let inp = document.getElementById('password');
        e = e.type == "submit";
        
            
       // verifica se tem ao menos uma letra maiúscula
       if(v.match(/[A-Z]{1,}/)) {
        qtde++;
       } else {
        tip = "| Ao menos uma letra maiúscula";
       }
        
       // verifica de tem ao menos um número
       if(v.match(/[0-9]{1,}/)) {
        qtde++; 
        
       } else {
        tip = "| Ao menos um número";
       }
            
       // verifica se tem 6 caracteres ou mais
       if(v.match(/.{6,}/)) {
        qtde++;
       } else {
        tip = "| Ao menos seis caracteres";
       }
 
       var validacao = 'Fraca';
       inp.classList.add('invalid');
       inp.classList.remove('valid');
       switch (qtde)
       {
            case 2:
                validacao = 'M\u00e9dia'; break;
            case 3:
                validacao = 'Forte'; 
                inp.classList.remove('invalid');
                inp.classList.add('valid');
                tip = ""; 
                break;
       }

       out.innerHTML = "<strong>For\u00e7a:&nbsp;</strong>" + validacao + " " + tip;
    }
});

// https://stackoverflow.com/questions/948172/password-strength-meter