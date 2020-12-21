(function () {
    "use strict";

    // Variable globales
    const body = document.querySelector("body");
    const toggleButtonFont = document.querySelector(".font");
    const currentFont = localStorage.getItem("currentFont");
    const currentTheme = localStorage.getItem("currentTheme");
    const toggleButtonAccessibility = document.querySelector(".btn-accessibility");
    const btnAlertNotification = document.querySelector('.btn-close');
    const alertNotification = document.querySelector('.notification');
    const iconEye = document.querySelector("#icon-eye");
    const iconFont = document.querySelector("#icon-font");
    const translationBtn = document.querySelector(".topbar-lang");
    const translationList = document.querySelector(".list-lang");

    // Font Open Dyslexic
    toggleButtonFont.addEventListener("click", () => {
        if (body.classList.contains("dislexic")) {
            body.classList.remove("dislexic");
            iconFont.classList.remove("active-access");
            localStorage.setItem("currentFont", "normal");
        } else {
            fontDislexic();
        }
    });

    if (currentFont === "dislexic") {
        fontDislexic();
    }

    function fontDislexic() {
        body.classList.add("dislexic");
        iconFont.classList.add("active-access");
        localStorage.setItem("currentFont", "dislexic");
    }

    // Theme accessibility
    toggleButtonAccessibility.addEventListener("click", () => {
        if (body.classList.contains("accessibility")) {
            body.classList.remove("accessibility");
            iconEye.classList.remove("active-access");
            localStorage.setItem("currentTheme", "clair");
        } else {
            themeAccessibility();
        }
    });

    if (currentTheme === "accessibility") {
        themeAccessibility();
    }

    function themeAccessibility() {
        body.classList.add("accessibility");
        iconEye.classList.add("active-access");
        localStorage.setItem("currentTheme", "accessibility");
    }

    // Translation switcher
    translationBtn.addEventListener("click", () => {
        translationList.classList.toggle("active");
    })


    // Alert Notification
    btnAlertNotification.addEventListener('click', () => {
        return alertNotification.style.display = "none";
    })

})();


