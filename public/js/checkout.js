const BASE_URL = "http://127.0.0.1:8000";

const checkoutForm = document.querySelector("#checkout-form");

function onResponse(response) {
    if (!response.ok) {
        console.log("Risposta non valida");
        return null;
    } else {
        location.href = BASE_URL + "/home";
    }
}




function onError(error) {
    console.log("Error: " + error);
    alert("Errore di rete.");
    if (checkoutForm) {
        const submitBtn = checkoutForm.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = false;
    }
}

function onCheckoutSubmit(e) {
    e.preventDefault();
    const submitBtn = checkoutForm.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = metaToken.content;
    const formData = new FormData(checkoutForm);
    const bodyData = new URLSearchParams(formData);
    fetch(BASE_URL + "/checkout", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: bodyData,
    }).then(onResponse, onError);
}

if (checkoutForm) {
    checkoutForm.addEventListener("submit", onCheckoutSubmit);
}
