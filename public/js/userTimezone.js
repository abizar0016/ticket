(function () {
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    if (!localStorage.getItem('timezone_sent')) {
        fetch('/set-timezone', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({ timezone })
        })
        .then(response => {
            if (response.ok) {
                localStorage.setItem('timezone_sent', '1');
                location.reload();
            } else {
                console.error('Failed set timezone:', response.status);
            }
        })
        .catch(err => console.error('Fetch error:', err));
    }
})();
