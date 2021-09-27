window.addEventListener('load', () => {
    let btn = window.document.querySelector('.product-overview .top .right .btn');
    let id_product = new URLSearchParams(window.location.search).get('id');

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
        let id_product = window.document.querySelectorAll('#products .product');
        let add_cart = window.document.querySelectorAll('#products .product .to-cart');
        let cart_number = window.document.querySelector('.shop-car span:not(:empty)');
    
        add_cart.forEach((element, key) => {
            element.addEventListener('click', () => {
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "../../app/manageCart.php");
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = (e) => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        //console.log('id='+id_product[key].id + '&add=1');
                    }
                };
                xhr.send('id='+id_product[key].id + '&add=1');
            })
        })
    
    }
})