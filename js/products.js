window.addEventListener('load', () => {
    let btn = window.document.querySelector('.product-overview .top .right .btn');
    let id_product = new URLSearchParams(window.location.search).get('id');

    // Single product page
    if (btn != null)
    btn.addEventListener('click', () => {

        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../../app/manageCart.php");
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = (e) => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.replace("cart.php");
            }
        };
        xhr.send('id='+id_product + '&add=1');

    })
    else {
        // All products page
        let id_product = window.document.querySelectorAll('#products .product');
        let add_cart = window.document.querySelectorAll('#products .product .to-cart');
        let cart_icon = window.document.querySelector('.shop-car a span');
        let cart_items = [];

        add_cart.forEach((element, key) => {
            element.addEventListener('click', () => {
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "../../app/manageCart.php");
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = (e) => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (!(cart_items.indexOf(id_product[key].id) != -1)) {
                            if (cart_icon.innerHTML == '') cart_icon.innerHTML = 1;
                            else cart_icon.innerHTML = parseInt(cart_icon.innerHTML) + 1;
                            cart_items.push(id_product[key].id);
                        }
                    }
                };
                xhr.send('id='+id_product[key].id + '&add=1');
            })
        })
    
    }
})