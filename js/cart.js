window.addEventListener('load', () => {
    let quantity = window.document.querySelectorAll('.list-item .input-quantity');
    let ids = window.document.querySelectorAll('.list-item');
    let exclude = window.document.querySelectorAll('.list-item .list-interaction img');

    let inputRadio = window.document.querySelectorAll('.adress_box .adress_top input[type="radio"]');
    let adresses = window.document.querySelectorAll('.adresses .adress_box');
    let btnSend = window.document.getElementById('payment_button');

    // Change main adress
    if (adresses != null && adresses[0].id != '') {
        var adress_id = adresses[0].id;
        adresses[0].classList.add('choosen');

        inputRadio.forEach((element, key) => {
            element.addEventListener('change', () => {
                adresses.forEach((element) => {
                    element.classList.remove('choosen');
                })
                console.log(adresses[key].id);
                adress_id = adresses[key].id
                adresses[key].classList.add('choosen');
            })
        })
    }
    
    // When quantity number changes
    quantity.forEach((element, key) => {
        element.addEventListener('change', () => {
            if(element.value == 0) {
                if (ids.length == 1) {
                    ids[key].innerHTML = '<div class="list-name">Nenhum produto no carrinho.<a href="products.php">Vamos as compras!</a></div>';
                } else {
                    ids[key].remove();
                }
            }

            changePrice();
            listIsEmpty();

            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {}
            };
            xhr.send('id_update='+ids[key].id + '&quantity='+quantity[key].value);
        })
    })

    // Exclude button
    exclude.forEach((element, key) => {
        element.addEventListener('click', () => {
            var xhr = new XMLHttpRequest();

            quantity[key].value = 0;
            changePrice();
            listIsEmpty();
            
            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (ids.length == 1) {
                        ids[key].innerHTML = '<div class="list-name">Nenhum produto no carrinho.<a href="products.php">Vamos as compras!</a></div>';
                    } else {
                        ids[key].remove();
                    }
                }
            };
            xhr.send('remove='+element.id);
        })
    })
    // Sending the cart to payment
    btnSend.addEventListener('click', () => {

        if (adresses[0].id != '' && window.document.getElementsByClassName('choosen') != null) {
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/payment.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText == 'Sucess') {
                        window.location ="user.php?page=orders";
                    }
                }
            };
            if (ids.length > 0) {
                xhr.send('payment=1&adress='+adress_id);
            }
        } else {
            alert('Adicione um endereço primeiro!')
        }

    })

    let totalPrice = window.document.querySelector('#total-price');
    let listPrice = window.document.querySelectorAll('.list-price');
    let listEmpty = window.document.querySelector('#empty');

    function changePrice() {
        let value = 0;
        quantity.forEach((element, key) => {
            value += parseInt(quantity[key].value) * parseFloat(listPrice[key + 1].innerHTML);
        })
        totalPrice.innerHTML = "R$ " + value;
    }

    function listIsEmpty() {
        if(totalPrice.innerHTML == "R$ 0") {
            listEmpty.innerHTML = `<div class="list-item">
                                    <div class="list-name"> 
                                        Nenhum produto no carrinho. <a href="products.php">Vamos as compras!</a>
                                    </div>
                                </div>`
        }
    }
})