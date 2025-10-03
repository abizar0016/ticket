document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("form.ajax-form").forEach((form) => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const runAjax = () => {
                const formData = new FormData(form);
                const actionUrl = form.getAttribute("action");
                const csrf = form.querySelector('input[name="_token"]')?.value;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.innerHTML : "";
                const successMessage = form.dataset.success || "Saved successfully!";

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                }

                fetch(actionUrl, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                })
                .then(async (res) => {
                    const data = await res.json();

                    if (res.ok && data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || successMessage,
                            icon: 'success',
                            confirmButtonColor: '#6366F1'
                        }).then(() => {
                            if (form.dataset.reload !== "false") {
                                window.location.reload();
                            }
                        });
                    } else {
                        let errorMessage = data.message || 
                            (data.errors ? Object.values(data.errors).join('<br>') : "Something went wrong");

                        Swal.fire({
                            title: 'Oops!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Network Error',
                        text: 'Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                });
            };

            const confirmMsg = form.dataset.confirm;
            if (confirmMsg) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: confirmMsg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        runAjax();
                    }
                });
            } else {
                runAjax();
            }
        });
    });
});
