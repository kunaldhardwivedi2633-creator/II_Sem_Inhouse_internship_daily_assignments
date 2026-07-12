/* =========================================================
   script.js
   Client-side validation and small UI helpers.
   Note: We ALSO validate everything again in PHP, because
   JavaScript validation can be bypassed by the user.
   ========================================================= */

// Run once the page has fully loaded
document.addEventListener("DOMContentLoaded", function () {

    // ---------------- Registration form validation ----------------
    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            let isValid = true;

            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirm_password");

            clearError(name);
            clearError(email);
            clearError(password);
            clearError(confirmPassword);

            // Required field checks
            if (name.value.trim() === "") {
                showError(name, "Full name is required.");
                isValid = false;
            }

            if (email.value.trim() === "") {
                showError(email, "Email is required.");
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, "Please enter a valid email address.");
                isValid = false;
            }

            if (password.value === "") {
                showError(password, "Password is required.");
                isValid = false;
            } else if (password.value.length < 6) {
                showError(password, "Password must be at least 6 characters.");
                isValid = false;
            }

            if (confirmPassword.value !== password.value) {
                showError(confirmPassword, "Passwords do not match.");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // stop the form from submitting
            }
        });
    }

    // ---------------- Login form validation ----------------
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            let isValid = true;
            const email = document.getElementById("email");
            const password = document.getElementById("password");

            clearError(email);
            clearError(password);

            if (email.value.trim() === "") {
                showError(email, "Email is required.");
                isValid = false;
            }
            if (password.value === "") {
                showError(password, "Password is required.");
                isValid = false;
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // ---------------- Voting form: require one option selected ----------------
    const voteForm = document.getElementById("voteForm");
    if (voteForm) {
        voteForm.addEventListener("submit", function (e) {
            const options = voteForm.querySelectorAll('input[name="option_id"]');
            let selected = false;
            options.forEach(function (opt) {
                if (opt.checked) selected = true;
            });
            if (!selected) {
                alert("Please select one option before voting.");
                e.preventDefault();
            }
        });
    }

    // ---------------- Admin: dynamically add more poll option fields ----------------
    const addOptionBtn = document.getElementById("addOptionBtn");
    if (addOptionBtn) {
        addOptionBtn.addEventListener("click", function () {
            const container = document.getElementById("optionsContainer");
            const row = document.createElement("div");
            row.className = "option-row";
            row.innerHTML = `
                <input type="text" name="options[]" placeholder="Enter option text" required>
                <button type="button" class="btn btn-danger btn-small removeOptionBtn">Remove</button>
            `;
            container.appendChild(row);
        });

        // Allow removing dynamically added option rows
        document.getElementById("optionsContainer").addEventListener("click", function (e) {
            if (e.target.classList.contains("removeOptionBtn")) {
                e.target.parentElement.remove();
            }
        });
    }
});

// Helper: check email format using a simple regex
function isValidEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

// Helper: show an error message under an input field
function showError(input, message) {
    input.style.borderColor = "#e63946";
    let errorSpan = input.parentElement.querySelector(".error-text");
    if (!errorSpan) {
        errorSpan = document.createElement("span");
        errorSpan.className = "error-text";
        input.parentElement.appendChild(errorSpan);
    }
    errorSpan.textContent = message;
}

// Helper: clear a previously shown error message
function clearError(input) {
    input.style.borderColor = "";
    const errorSpan = input.parentElement.querySelector(".error-text");
    if (errorSpan) {
        errorSpan.remove();
    }
}
