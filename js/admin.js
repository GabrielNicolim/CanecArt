var loadFile = (event) => {
    var output = document.getElementById('preview_output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = () => {
    URL.revokeObjectURL(output.src) // free memory
    }
};

function updateprofit(){
    let value = Number(document.getElementById('price_product').value);
    let icms = Number(document.getElementById('icms_product').value);
    let base = Number(document.getElementById('base_cost_product').value);
    let span = document.getElementById('profit');
    if (value != '') {
        let profit = Number(value-base) * (1 - icms/100);
        span.style.color = (profit > 0) ? 'Green' : 'Red';
        span.innerHTML = 'Lucro por unidade: R$ ' + parseFloat(profit).toFixed(2) + ' ou ' + parseFloat(profit/value*100).toFixed(2) +'% do valor final';
    } else {
        span.innerHTML = 'Lucro por unidade: R$ 0,00 ou 0,00% do valor final';
    }
}
window.addEventListener('load', () => {
    updateprofit()
});