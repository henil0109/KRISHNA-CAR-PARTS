<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    
    <style>
        :root {
            --kk-black: #0b0d10;
            --kk-dark: #111317;
            --kk-mid: #1b1f27;
            --kk-accent: #ff3b2f;
            --kk-accent-2: #00ffe5;
            --kk-white: #f6f7fb;
        }
        
        body {
            background: linear-gradient(135deg, var(--kk-black) 0%, var(--kk-dark) 50%, var(--kk-mid) 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 2rem 0;
        }
        
        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ff3b2f" stop-opacity="0.1"/><stop offset="100%" stop-color="%2300ffe5" stop-opacity="0.05"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="800" r="400" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .auth-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(0, 255, 229, 0.1);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--kk-accent), var(--kk-accent-2));
            border-radius: 24px 24px 0 0;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--kk-accent), var(--kk-accent-2));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .logo i {
            font-size: 2rem;
            color: white;
        }
        
        .auth-title {
            color: var(--kk-white);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            color: rgba(246, 247, 251, 0.7);
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--kk-white);
            padding: 1rem 3rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--kk-accent-2);
            cursor: pointer;
            font-size: 1.1rem;
        }
        

        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--kk-accent-2);
            box-shadow: 0 0 0 4px rgba(0, 255, 229, 0.2);
            color: var(--kk-white);
        }
        
        .form-control::placeholder {
            color: rgba(246, 247, 251, 0.5);
        }
        
        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--kk-accent-2);
            font-size: 1.1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--kk-accent), var(--kk-accent-2));
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 59, 47, 0.4);
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .divider span {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            color: rgba(246, 247, 251, 0.7);
            padding: 0 1rem;
            font-size: 0.9rem;
        }
        
        .google-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            width: 100%;
            color: var(--kk-white);
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .google-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: var(--kk-white);
        }
        
        .auth-switch {
            text-align: center;
            margin-top: 2rem;
            color: rgba(246, 247, 251, 0.7);
        }
        
        .auth-switch a {
            color: var(--kk-accent-2);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .auth-switch a:hover {
            color: var(--kk-accent);
        }
        
        .alert {
            background: rgba(255, 59, 47, 0.1);
            border: 1px solid rgba(255, 59, 47, 0.3);
            color: var(--kk-accent);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .alert.success {
            background: rgba(0, 255, 229, 0.1);
            border-color: rgba(0, 255, 229, 0.3);
            color: var(--kk-accent-2);
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(255, 59, 47, 0.1), rgba(0, 255, 229, 0.1));
            border-radius: 50%;
            animation: float-shapes 15s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }
        
        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 10s;
        }
        
        @keyframes float-shapes {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(30px) rotate(240deg); }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="logo-section">
                            <div class="logo">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2 class="auth-title">Create Account</h2>
                            <p class="auth-subtitle">Join Krishna Car Parts community today</p>
                        </div>
                        
                        <?php if(isset($_GET['error'])): ?>
                        <div class="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(isset($_GET['success'])): ?>
                        <div class="alert success">
                            <i class="fas fa-check-circle me-2"></i>
                            Account created successfully! Please sign in.
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="auth-process.php">
                            <input type="hidden" name="action" value="signup">
                            
                            <div class="form-group">
                                <i class="fas fa-user form-icon"></i>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-envelope form-icon"></i>
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-phone form-icon"></i>
                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required minlength="8" onclick="showPasswordInfo()">
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('confirm_password')"></i>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                        
                        <div class="divider">
                            <span>or continue with</span>
                        </div>
                        
                        <button class="google-btn" onclick="signInWithGoogle()">
                            <i class="fab fa-google"></i>
                            Continue with Google
                        </button>
                        
                        <div class="auth-switch">
                            Already have an account? <a href="login.php">Sign in here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function signInWithGoogle() {
            alert('Google Sign-In will be available soon. Please use email signup for now.');
        }
        
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        let passwordInfoShown = false;
        
        function showPasswordInfo() {
            if (!passwordInfoShown) {
                alert('Password Requirements:\n\n• At least 8 characters\n• One uppercase letter (A-Z)\n• One lowercase letter (a-z)\n• One number (0-9)');
                passwordInfoShown = true;
            }
        }
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            
            // Password strength validation
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                e.preventDefault();
                alert('Password must meet all requirements!');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>