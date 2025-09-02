/**
 * Installation Wizard JavaScript Enhancement
 * Provides smooth transitions and enhanced user experience
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('installationForm');
    const finishButton = document.getElementById('finishButton');
    
    // Initialize wizard functionality
    initializeFormHandlers();
    initializeColorPreview();
    initializeFormValidation();
    initializeProgressAnimations();

    /**
     * Initialize form submission handlers
     */
    function initializeFormHandlers() {
        if (!form) return;

        form.addEventListener('submit', function(e) {
            const action = e.submitter ? e.submitter.value : 'next';
            
            if (action === 'finish') {
                handleFinishSubmission();
            } else {
                handleStepTransition(action);
            }
        });
    }

    /**
     * Handle finish button submission with loading state
     */
    function handleFinishSubmission() {
        if (finishButton) {
            finishButton.disabled = true;
            
            const finishText = finishButton.querySelector('.finish-text');
            const loadingText = finishButton.querySelector('.loading-text');
            
            if (finishText && loadingText) {
                finishText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            }
        }
    }

    /**
     * Handle step transitions with animations
     */
    function handleStepTransition(action) {
        const mainCard = document.querySelector('.bg-white.rounded-2xl');
        
        if (mainCard) {
            mainCard.style.opacity = '0.8';
            mainCard.style.transform = 'scale(0.98)';
            
            setTimeout(() => {
                mainCard.style.opacity = '1';
                mainCard.style.transform = 'scale(1)';
            }, 150);
        }
    }

    /**
     * Initialize real-time color preview functionality
     */
    function initializeColorPreview() {
        const colorInputs = [
            {
                input: document.getElementById('brandPrimaryColor'),
                preview: document.getElementById('primaryColorPreview'),
                textInput: document.querySelector('input[name="brandPrimaryColor"][type="text"]')
            },
            {
                input: document.getElementById('brandSecondaryColor'),
                preview: document.getElementById('secondaryColorPreview'),
                textInput: document.querySelector('input[name="brandSecondaryColor"][type="text"]')
            }
        ];

        colorInputs.forEach(({ input, preview, textInput }) => {
            if (!input || !preview) return;

            // Handle color picker changes
            input.addEventListener('input', function() {
                const color = this.value;
                preview.style.backgroundColor = color;
                
                if (textInput) {
                    textInput.value = color;
                }
                
                animateColorPreview(preview);
            });

            // Handle text input changes
            if (textInput) {
                textInput.addEventListener('input', function() {
                    const color = this.value;
                    
                    if (isValidColor(color)) {
                        preview.style.backgroundColor = color;
                        input.value = color;
                        animateColorPreview(preview);
                    }
                });

                // Sync color picker with text input on page load
                input.addEventListener('change', function() {
                    if (textInput) {
                        textInput.value = this.value;
                    }
                });
            }
        });
    }

    /**
     * Animate color preview changes
     */
    function animateColorPreview(element) {
        if (!element) return;
        
        element.style.transform = 'scale(1.1)';
        element.style.transition = 'all 0.2s ease';
        
        setTimeout(() => {
            element.style.transform = 'scale(1)';
        }, 200);
    }

    /**
     * Validate if a string is a valid hex color
     */
    function isValidColor(color) {
        return /^#[A-Fa-f0-9]{6}$/.test(color);
    }

    /**
     * Initialize form validation with visual feedback
     */
    function initializeFormValidation() {
        const requiredInputs = form.querySelectorAll('input[required], textarea[required]');
        
        requiredInputs.forEach(input => {
            // Add blur validation
            input.addEventListener('blur', function() {
                validateField(this);
            });

            // Add input validation for real-time feedback
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-300')) {
                    validateField(this);
                }
            });
        });

        // Email validation
        const emailInputs = form.querySelectorAll('input[type="email"]');
        emailInputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateEmail(this);
            });
        });

        // Password confirmation validation
        const passwordInput = document.getElementById('adminPassword');
        const confirmPasswordInput = document.getElementById('adminPasswordConfirmation');
        
        if (passwordInput && confirmPasswordInput) {
            [passwordInput, confirmPasswordInput].forEach(input => {
                input.addEventListener('input', function() {
                    validatePasswordMatch();
                });
            });
        }
    }

    /**
     * Validate individual field
     */
    function validateField(field) {
        const isValid = field.value.trim() !== '';
        
        if (isValid) {
            field.classList.remove('border-red-300');
            field.classList.add('border-green-300');
            setTimeout(() => {
                field.classList.remove('border-green-300');
                field.classList.add('border-gray-300');
            }, 1000);
        } else {
            field.classList.add('border-red-300');
            field.classList.remove('border-gray-300');
        }
        
        return isValid;
    }

    /**
     * Validate email format
     */
    function validateEmail(emailField) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailRegex.test(emailField.value);
        
        if (isValid) {
            emailField.classList.remove('border-red-300');
            emailField.classList.add('border-green-300');
            setTimeout(() => {
                emailField.classList.remove('border-green-300');
                emailField.classList.add('border-gray-300');
            }, 1000);
        } else if (emailField.value.trim() !== '') {
            emailField.classList.add('border-red-300');
            emailField.classList.remove('border-gray-300');
        }
        
        return isValid;
    }

    /**
     * Validate password confirmation match
     */
    function validatePasswordMatch() {
        const passwordInput = document.getElementById('adminPassword');
        const confirmPasswordInput = document.getElementById('adminPasswordConfirmation');
        
        if (!passwordInput || !confirmPasswordInput) return;
        
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword.length > 0 && password !== confirmPassword) {
            confirmPasswordInput.classList.add('border-red-300');
            confirmPasswordInput.classList.remove('border-gray-300');
            return false;
        } else if (confirmPassword.length > 0 && password === confirmPassword) {
            confirmPasswordInput.classList.remove('border-red-300');
            confirmPasswordInput.classList.add('border-green-300');
            setTimeout(() => {
                confirmPasswordInput.classList.remove('border-green-300');
                confirmPasswordInput.classList.add('border-gray-300');
            }, 1000);
            return true;
        }
    }

    /**
     * Initialize progress step animations
     */
    function initializeProgressAnimations() {
        const stepIndicators = document.querySelectorAll('.flex-shrink-0.w-10.h-10');
        
        stepIndicators.forEach((indicator, index) => {
            indicator.style.transition = 'all 0.3s ease';
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${getNotificationClasses(type)}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    /**
     * Get notification CSS classes based on type
     */
    function getNotificationClasses(type) {
        const classes = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        
        return classes[type] || classes.info;
    }
});