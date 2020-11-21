/*
//Добавление в корзину
let number = 1;

let forms = document.querySelectorAll('#addProduct');

for (let formData of forms ) {
    formData.addEventListener('submit', function (event) {
        event.preventDefault();

        axios.post(formData.action, {
            data: new FormData(this)
        })
            .then(function (response) {
                console.log(response);
                let cartCount = document.querySelector('.cart');
                cartCount.innerHTML = "("+ response.data.data + ")";

                let AddProd = document.querySelector('.productAdd');
                AddProd.style.display='block';
                setTimeout(() => AddProd.style.display='none', 3000);

                let count = document.querySelector('#basketCount');
                number++;
                count.innerHTML= number;



            })
            .catch(function (error) {
                console.log(error);
            });
    });
}
//Удаление из корзины
let formsDel = document.querySelectorAll('#delProduct');

for (let formData of formsDel ) {
    formData.addEventListener('submit', function (event) {
        event.preventDefault();

        axios.post(formData.action, {
        })
            .then(function (response) {
                let count = document.querySelector('#basketCount');
                number--;
                count.innerHTML= number;
                console.log(number)

            })
            .catch(function (error) {
                console.log(error);
            });
    });
}
*/

