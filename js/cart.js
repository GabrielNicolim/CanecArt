window.addEventListener('load', () => {
    let quantity = window.document.querySelectorAll('.list-item .input-quantity');
    let ids = window.document.querySelectorAll('.list-item');
    let exclude = window.document.querySelectorAll('.list-item .list-interaction img');

    let inputRadio = window.document.querySelectorAll('.adress_box .adress_top input[type="radio"]');
    let adresses = window.document.querySelectorAll('.adresses .adress_box');
    let btnSend = window.document.getElementById('payment_button');

    // Change main adress
    if (adresses != null) {
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

            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // console.log('aaa');
                }
            };
            xhr.send('id_update='+ids[key].id + '&quantity='+quantity[key].value);
        })
    })

    // Exclude button
    exclude.forEach((element, key) => {
        element.addEventListener('click', () => {
            var xhr = new XMLHttpRequest();

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

    })
})