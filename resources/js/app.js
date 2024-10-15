document?.getElementById('payButton')?.addEventListener('click', function(e) {
    e.preventDefault();
    // Собираем данные формы
    const errorsBlock = document.getElementById('errors');
    const plan = document.getElementById('plan').value.trim();
    const cardNumber = document.getElementById('CardNumber').value.trim();
    const expiryDate = document.getElementById('expiryDate').value.trim();
    const remember = document.getElementById('remember').checked;

    errorsBlock.innerHTML = '';

    // Подготавливаем данные для отправки
    const formData = {
        card_number: cardNumber,
        expiry_date: expiryDate,
        remember: remember ? 1 : 0
    };

    // Отправляем данные через axios
    axios.post(`/payment/store/${plan}`, formData)
    .then(function (response) {
        // Обработка успешного ответа
        errorsBlock.innerHTML = ''; // Если успешно, очищаем ошибки

        if (response.data?.error) {
                const errorItem = document.createElement('p');
                errorItem.classList.add('text-danger');
                errorItem.textContent = response.data?.error;
                errorsBlock.appendChild(errorItem);
        }

    })
    .catch(function (error) {
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