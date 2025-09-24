document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggler
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const eyeIcon = this.querySelector('i');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Form submission handler
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.querySelector('.auth-button');
    const buttonSpinner = document.querySelector('.button-spinner');
    
    if (loginForm && loginButton && buttonSpinner) {
        loginForm.addEventListener('submit', function() {
            // Show loading spinner
            loginButton.disabled = true;
            buttonSpinner.style.display = 'inline-block';
            loginButton.innerHTML = 'Logging in ' + buttonSpinner.outerHTML;
        });
    }
    
    // Input validation styling
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            // Validate on blur
            if (this.value.trim() !== '') {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
});