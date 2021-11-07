let btn_pay = window.document.querySelectorAll('.list-name button');

btn_pay.forEach((element, key) => {
    element.addEventListener('click', () => {             
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../../app/payOrder.php");
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = (e) => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText == 'Order '+btn_pay[key].id+' Paid!') {
                    location.reload();
                }
            }
        };
        xhr.send('order='+btn_pay[key].id);
    })
})