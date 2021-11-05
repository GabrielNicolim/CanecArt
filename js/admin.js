var loadFile = (event) => {
    var output = document.getElementById('preview_output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = () => {
    URL.revokeObjectURL(output.src) // free memory
    }
};

function updateValue(){
    let profit = Number(document.getElementById('profit_margin').value);
    let base = Number(document.getElementById('base_cost_product').value);
    let span = document.getElementById('profit');

    if (profit != '') {
        // (custo + (custo * (1 - margem/100)) * (1 - icms/100)
        let value = (Number(base) + (Number(base) * (1 - profit/100))) / 0.82
        span.style.color = (value > base) ? 'Green' : 'Red';
        span.innerHTML = 'Custo final por unidade: R$ ' + parseFloat(value).toFixed(2) + ' (com ICMS de 18%) ';// + parseFloat(profit/value*100).toFixed(2) +'% do valor final';
    } else {
        span.innerHTML = 'Custo final por unidade: R$ 0,00 ou 0,00% do valor final';
    }
}

function inputFilter(value) {
    return /^\d*\.?\d*$/.test(value);
};

function isValid(e) {
    if(!inputFilter(e.target.value)) {
        let data = e.target.value.split(''); 
        let str = '';

        for(let i = 0; i < data.length - 1; i++) {
            str += data[i];
        }

        e.target.value = str; 
    }
}

window.addEventListener('load', () => {    
    document.getElementById('base_cost_product').addEventListener('input', (e) => {
        isValid(e);
    })

    document.getElementById('profit_margin').addEventListener('input', (e) => {
        isValid(e);
    })

    document.getElementById('quantity_product').addEventListener('input', (e) => {
        isValid(e);
    })  
})
