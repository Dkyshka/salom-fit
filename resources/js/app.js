document?.getElementById('payButton')?.addEventListener('click', function(e) {
    e.preventDefault();
    // Собираем данные формы
    const errorsBlock = document.getElementById('errors');
    const plan = document.getElementById('plan').value.trim();
    const cardNumber = document.getElementById('CardNumber').value.trim();
    const expiryDate = document.getElementById('expiryDate').value.trim();

    errorsBlock.innerHTML = '';

    // Подготавливаем данные для отправки
    const formData = {
        card_number: cardNumber,
        expiry_date: expiryDate,
    };

    // Отправляем данные через axios
    axios.post(`/payment/store/${plan}`, formData, {
        headers: {
            'X-Auth': '5e730e8e0b852a417aa49ceb',  // Добавляем заголовок X-Auth, если требуется
            'Content-Type': 'application/json'
        }
    })
        .then(function (response) {
            // Обработка успешного ответа
            console.log('Payment successful:', response.data);
            errorsBlock.innerHTML = ''; // Если успешно, очищаем ошибки
        })
        .catch(function (error) {
            // Обработка ошибки
            console.error('Payment failed:', error.response);
            // Если валидация не прошла, выводим ошибки
            if (error.response && error.response.data && error.response.data.errors) {
                const errors = error.response.data.errors;

                // Проходим по ошибкам и добавляем их в блок с id 'errors'
                Object.keys(errors).forEach(function (field) {
                    errors[field].forEach(function (message) {
                        const errorItem = document.createElement('p');
                        errorItem.classList.add('text-danger');
                        errorItem.textContent = message;
                        errorsBlock.appendChild(errorItem);
                    });
                });
            }
        });
});