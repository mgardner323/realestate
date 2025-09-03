<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-8">

                <!-- Title -->
                <h2 class="text-3xl font-bold text-center text-gray-800">
                    @if($view === 'register')
                        Create an Account
                    @else
                        Welcome Back
                    @endif
                </h2>
                <p class="text-center text-gray-500 mt-2">
                    @if($view === 'register')
                        Get started with your new account.
                    @else
                        Sign in to continue.
                    @endif
                </p>

                <!-- Google Sign-in Button -->
                <div class="mt-8">
                    <button id="googleSignInBtn" class="w-full flex items-center justify-center gap-2 p-3 rounded-md border border-gray-300 hover:bg-gray-50 transition-colors" onclick="handleGoogleSignIn()">
                        <svg class="w-5 h-5" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.012,35.346,44,30.028,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-600">Sign in with Google</span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-sm font-medium text-gray-500">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Form -->
                <form id="authForm" method="POST" class="space-y-6" data-view="{{ $view }}">
                    @csrf
                    <!-- Server-side Error Display -->
                    @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Client-side Error Display Area -->
                    <div id="auth-error" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p id="auth-error-message" class="text-sm text-red-700"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="you@example.com" required>
                    </div>
                    
                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••" required>
                    </div>

                    <!-- Confirm Password Input (only for registration) -->
                    @if($view === 'register')
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                    </div>
                    @endif

                    <!-- Forgot Password Link (only for login) -->
                    @if($view === 'login')
                    <div class="flex items-center justify-end">
                        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    @endif
                    
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" id="submitBtn" class="w-full py-3 px-4 text-white bg-blue-600 rounded-md font-semibold hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            @if($view === 'register')
                                Create Account
                            @else
                                Login
                            @endif
                        </button>
                    </div>
                </form>
                
                <!-- Switcher Link -->
                <p class="text-sm text-center text-gray-500 mt-6">
                    @if($view === 'login')
                        Don't have an account?
                        <a href="/register" class="font-medium text-blue-600 hover:underline">Sign up</a>
                    @else
                        Already have an account?
                        <a href="/login" class="font-medium text-blue-600 hover:underline">Log in</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Firebase Configuration and Logic -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import { getAuth, GoogleAuthProvider, signInWithPopup, createUserWithEmailAndPassword, sendEmailVerification, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') ?: env('VITE_FIREBASE_API_KEY') }}",
        authDomain: "{{ config('services.firebase.auth_domain') ?: env('VITE_FIREBASE_AUTH_DOMAIN') }}",
        projectId: "{{ config('services.firebase.project_id') ?: env('VITE_FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') ?: env('VITE_FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') ?: env('VITE_FIREBASE_MESSAGING_SENDER_ID') }}",
        appId: "{{ config('services.firebase.app_id') ?: env('VITE_FIREBASE_APP_ID') }}",
    };

    console.log('Firebase Config:', firebaseConfig); // Debug log

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    async function verifyToken(user) {
        try {
            console.log('Getting ID token for user:', user.email);
            const token = await user.getIdToken();
            console.log('Token obtained, calling backend verification...');
            await @this.call('verifyToken', token);
        } catch (error) {
            console.error('Error getting ID token:', error);
            alert('Could not log you in. Please try again.');
        }
    }
    
    // Robust form handling with proper event listener
    document.addEventListener('DOMContentLoaded', function() {
        const authForm = document.getElementById('authForm');
        
        if (authForm) {
            authForm.addEventListener('submit', function(event) {
                // CRITICAL: Prevent default form submission immediately
                event.preventDefault();
                console.log('Form submission intercepted by Firebase handler');
                
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password')?.value;
                const view = event.target.dataset.view; // 'login' or 'register'
                
                const errorDiv = document.getElementById('auth-error');
                const errorMessage = document.getElementById('auth-error-message');
                const submitBtn = document.getElementById('submitBtn');
                
                // Hide previous errors
                errorDiv.classList.add('hidden');
                
                // Show loading state
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Authenticating...';
                }
        
                console.log('Auth attempt:', { email, view });

                // Basic validation for registration
                if (view === 'register' && password !== confirmPassword) {
                    showError('Passwords do not match');
                    return;
                }
                
                // Minimum password length check
                if (password.length < 6) {
                    showError('Password must be at least 6 characters long');
                    return;
                }
                
                function showError(message) {
                    errorMessage.textContent = message;
                    errorDiv.classList.remove('hidden');
                    resetButton();
                }
                
                function resetButton() {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        if (view === 'register') {
                            submitBtn.innerHTML = 'Create Account';
                        } else {
                            submitBtn.innerHTML = 'Login';
                        }
                    }
                }

        if (view === 'register') {
            console.log('Attempting registration...');
            createUserWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    console.log('Registration successful:', userCredential.user.email);
                    alert('Registration successful! You are now logged in.');
                    verifyToken(userCredential.user);
                })
                .catch((error) => {
                    console.error('Registration Error:', error);
                    let message = 'Registration failed. Please try again.';
                    
                    if (error.code === 'auth/email-already-in-use') {
                        message = 'An account already exists with this email address.';
                    } else if (error.code === 'auth/weak-password') {
                        message = 'Password should be at least 6 characters.';
                    } else if (error.code === 'auth/invalid-email') {
                        message = 'Please enter a valid email address.';
                    }
                    
                    showError(message);
                });
        } else {
            console.log('Attempting login...');
            signInWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    console.log('Login successful:', userCredential.user.email);
                    verifyToken(userCredential.user);
                })
                .catch((error) => {
                    console.error('Login Error:', error);
                    let message = 'Login failed. Please try again.';
                    
                    if (error.code === 'auth/user-not-found') {
                        message = 'No account found with this email address.';
                    } else if (error.code === 'auth/wrong-password') {
                        message = 'Incorrect password.';
                    } else if (error.code === 'auth/invalid-email') {
                        message = 'Please enter a valid email address.';
                    } else if (error.code === 'auth/too-many-requests') {
                        message = 'Too many failed attempts. Please try again later.';
                    }
                    
                    showError(message);
                });
            }
        });
        }
    });

    window.handleGoogleSignIn = function() {
        console.log('Google sign-in attempted');
        signInWithPopup(auth, provider)
            .then((result) => {
                console.log('Google sign-in successful:', result.user.email);
                verifyToken(result.user);
            })
            .catch((error) => {
                console.error('Google Sign-In Error:', error);
                let message = 'Google sign-in failed. Please try again.';
                
                if (error.code === 'auth/popup-closed-by-user') {
                    message = 'Sign-in was cancelled.';
                } else if (error.code === 'auth/popup-blocked') {
                    message = 'Pop-up was blocked. Please allow pop-ups for this site.';
                }
                
                const errorDiv = document.getElementById('auth-error');
                const errorMessageEl = document.getElementById('auth-error-message');
                errorMessageEl.textContent = message;
                errorDiv.classList.remove('hidden');
            });
    }

</script>
