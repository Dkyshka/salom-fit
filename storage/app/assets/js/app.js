(() => {
    "use strict";
    function isWebp() {
        function testWebP(callback) {
            let webP = new Image;
            webP.onload = webP.onerror = function() {
                callback(webP.height == 2);
            };
            webP.src = "data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA";
        }
        testWebP((function(support) {
            let className = support === true ? "webp" : "no-webp";
            document.documentElement.classList.add(className);
        }));
    }
    let addWindowScrollEvent = false;
    setTimeout((() => {
        if (addWindowScrollEvent) {
            let windowScroll = new Event("windowScroll");
            window.addEventListener("scroll", (function(e) {
                document.dispatchEvent(windowScroll);
            }));
        }
    }), 0);
    window.addEventListener("load", pageLoad);
    function pageLoad() {
        document.documentElement;
        document.addEventListener("click", (e => {
            const targetElement = e.target;
            if (targetElement.closest(".referal__copy")) {
                const button = targetElement.closest(".referal__copy");
                const textToCopy = button.getAttribute("data-copy");
                const textarea = document.createElement("textarea");
                textarea.value = textToCopy;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand("copy");
                document.body.removeChild(textarea);
                button.classList.add("done");
            }
        }));
        const inputs = document.querySelectorAll(".sms__input");
        if (inputs.length > 0) {
            inputs[0].focus();
            inputs.forEach(((input, index) => {
                input.addEventListener("keypress", (event => {
                    if (!/[0-9]/.test(event.key)) event.preventDefault();
                }));
                input.addEventListener("input", (event => {
                    const value = event.target.value.replace(/[^0-9]/g, "");
                    if (value.length > 1) {
                        const chars = value.split("");
                        chars.forEach(((char, i) => {
                            if (inputs[index + i]) inputs[index + i].value = char;
                        }));
                        inputs[Math.min(index + chars.length, inputs.length - 1)].focus();
                    } else if (value.length === 1 && index < inputs.length - 1) inputs[index + 1].focus(); else if (value.length === 0 && index > 0) inputs[index - 1].focus();
                }));
                input.addEventListener("keydown", (event => {
                    if (event.key === "Backspace" && input.value === "" && index > 0) inputs[index - 1].focus();
                }));
                input.addEventListener("paste", (event => {
                    event.preventDefault();
                    const pasteData = event.clipboardData.getData("text").replace(/[^0-9]/g, "");
                    if (pasteData.length === 0) return;
                    const chars = pasteData.split("");
                    chars.slice(0, inputs.length).forEach(((char, i) => {
                        inputs[i].value = char;
                    }));
                    inputs[Math.min(chars.length - 1, inputs.length - 1)].focus();
                }));
            }));
        }
    }
    window["FLS"] = true;
    isWebp();
})();

function formatPhoneNumber(input) {
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

document.getElementById('phone')?.addEventListener('input', function (e) {
    // Форматируем введенный текст и обновляем значение input
    e.target.value = formatPhoneNumber(e.target.value);
});