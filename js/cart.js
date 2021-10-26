window.addEventListener('load', () => {
    let quantity = window.document.querySelectorAll('.list-item .input-quantity');
    let ids = window.document.querySelectorAll('.list-item');
    let exclude = window.document.querySelectorAll('.list-item .list-interaction img');
    let inputRadio = window.document.querySelectorAll('.adress_box .adress_top input[type="radio"]');
    let adresses = window.document.querySelectorAll('.adresses .adress_box');
    let btnSend = window.document.getElementById('payment_button');
    let cart_icon = window.document.querySelector('.shop-car a span');

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
                changePrice();
                listIsEmpty();
                ids[key].remove();
                cart_icon.innerHTML = parseInt(cart_icon.innerHTML.match(/\d+/g).join('')) - 1;
                if (cart_icon.innerHTML.includes('0')) cart_icon.innerHTML = '';
            }
                    
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    //console.log('a')
                }
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
            ids[key].remove();
            
            xhr.open("POST", "../../app/manageCart.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    listIsEmpty();
                    cart_icon.innerHTML = parseInt(cart_icon.innerHTML) - 1;
                    if (cart_icon.innerHTML == '0') cart_icon.innerHTML = '';
                }
            };
            xhr.send('remove='+element.id);
        })
    })
    // Sending the cart to payment
    btnSend.addEventListener('click', () => {

        let check = window.document.querySelectorAll('.list-item .list-name')[0].innerHTML

        if (check.includes('Nenhum produto no carrinho.')) {
            alert('Adicione produtos!')
        } else if (adresses[0].id != '' && window.document.getElementsByClassName('choosen') != null) {
            
            let loading = window.document.getElementById('opacity');
            loading.classList.remove('hidden');
            
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "../../app/createOrder.php");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = (e) => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText == 'Sucess') {
                        document.getElementById("loading").src="../icons/check-circle-solid.svg";

                        setTimeout(function () {
                            window.location ="user.php?page=orders";
                        }, 700);
                        
                    } else {
                        window.document.getElementById('error-out').classList.remove('hidden');
                        loading.classList.add('hidden');
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
        totalPrice.innerHTML = "R$ " + value.toFixed(2);
    }

    function listIsEmpty() {
        if(totalPrice.innerHTML.includes('R$ 0')) {
            listEmpty.innerHTML += `<div class="list-item">
                                    <div class="list-name"> 
                                        Nenhum produto no carrinho. <a href="products.php">Vamos as compras!</a>
                                    </div>
                                   </div>`
        }
    }
})