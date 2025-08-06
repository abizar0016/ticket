document.addEventListener("DOMContentLoaded", function () {

    // Copy Attendee Button
    document.querySelectorAll(".copy-attendee-btn").forEach((button) => {
        button.addEventListener("click", (e) => {
            const productId = e.currentTarget.getAttribute("data-product");
            const attendeeContainer = document.querySelector(
                `.attendee-list[data-product="${productId}"]`
            );

            if (!attendeeContainer) return;

            const nameInputs =
                attendeeContainer.querySelectorAll(".attendee-name");
            const emailInputs =
                attendeeContainer.querySelectorAll(".attendee-email");

            if (nameInputs.length < 2 || emailInputs.length < 2) return;

            const baseName = nameInputs[0].value.trim();
            const baseEmail = emailInputs[0].value.trim();

            if (!baseName || !baseEmail) {
                Swal.fire({
                    icon: "info",
                    title: "Perhatian",
                    text: "Isi nama dan email pertama terlebih dahulu.",
                    confirmButtonText: "OK",
                });
                return;
            }

            for (let i = 1; i < nameInputs.length; i++) {
                nameInputs[i].value = baseName;
                emailInputs[i].value = baseEmail;
            }

            const originalText = e.currentTarget.innerHTML;
            e.currentTarget.innerHTML =
                '<i class="ri-check-line mr-1"></i> Tersalin';

            setTimeout(() => {
                e.currentTarget.innerHTML = originalText;
            }, 2000);
        });
    });
});
