window.addEventListener('load', () => {
    let input = window.document.querySelectorAll('.list-item .input-quantity');
    let ids = window.document.querySelectorAll('.list-item');
    let exclude = window.document.querySelectorAll('.list-item .list-interaction img');

    let choosen = window.document.querySelector('.adress_box .adress_top input[type="radio" i]:checked').id;
    let parent_choosen = window.document.querySelector('.adress_box .adress_top input[type="radio" i]:checked').parentElement.parentElement;
    let btnSend = window.document.getElementById('payment_button');

    // Change main adress
    parent_choosen.classList.add('choosen')
    console.log(parent_choosen);

    
    // When input number changes
    input.forEach((element, key) => {
        element.addEventListener('change', () => {
            if(element.value == 0) {
                // if (ids.length == 1) {
                //     ids[key].innerHTML = '<div class="list-name">Nenhum produto no carrinho.<a href="products.php">Vamos as compras!</a></div>';
                // } else {
                //     ids[key].remove();
                // }
            }

            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // console.log('aaa');
                }
            };
            xhr.send('id_update='+ids[key].id + '&quantity='+input[key].value);
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
            xhr.send('payment=1&adress='+choosen);

        }

    })
})