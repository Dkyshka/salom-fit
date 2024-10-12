import './bootstrap';
import {formatPhoneNumber} from './functions.js';

document.getElementById('phone')?.addEventListener('input', function (e) {
    // Форматируем введенный текст и обновляем значение input
    e.target.value = formatPhoneNumber(e.target.value);
});