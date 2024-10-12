export function formatPhoneNumber(input) {
    // Удаляем все символы, кроме цифр
    let cleaned = input.replace(/\D/g, '');

    // Проверяем, начинается ли номер с кода страны +998
    if (!cleaned.startsWith('998')) {
        cleaned = '998' + cleaned;
    }

    // Форматируем по шаблону +998 99 999 99 99
    let formatted = '+998 ';

    if (cleaned.length > 3) {
        formatted += cleaned.slice(3, 5) + ' '; // Первые две цифры оператора
    }
    if (cleaned.length > 5) {
        formatted += cleaned.slice(5, 8) + ' '; // Три цифры
    }
    if (cleaned.length > 8) {
        formatted += cleaned.slice(8, 10) + ' '; // Еще две цифры
    }
    if (cleaned.length > 10) {
        formatted += cleaned.slice(10, 12); // Последние две цифры
    }

    return formatted.trim();
}