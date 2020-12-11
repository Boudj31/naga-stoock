(function() {
    "use strict";

    // Variable globales
    const body = document.querySelector("body");
    const toggleButtonFont = document.querySelector(".font");
    const currentFont = localStorage.getItem("currentFont");


    // Font Open Dyslexic
    toggleButtonFont.addEventListener("click", () => {
        if (body.classList.contains("dislexic")) {
            body.classList.remove("dislexic");
            localStorage.setItem("currentFont", "normal");
        } else {
            fontDislexic();
        }
    });
    
    if (currentFont === "dislexic") {
        fontDislexic();
    }

    function fontDislexic() {
        body.className = "dislexic";
        localStorage.setItem("currentFont", "dislexic");
    }

    
    // // Alert Notification
    // const btnAlert = document.querySelector('.btn-close');
    // const alertNotification = document.querySelector('.notification');

    // // Alert Notification
    // btnAlert.addEventListener('click', () => {
    //     return alertNotification.style.display = "none";
    // })

})();


