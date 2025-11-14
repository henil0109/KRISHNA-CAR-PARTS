<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Krishna Car Parts</title>
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
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .auth-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
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
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--kk-accent), var(--kk-accent-2));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
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
            text-align: center;
        }
        
        .auth-subtitle {
            color: rgba(246, 247, 251, 0.7);
            margin-bottom: 2rem;
            text-align: center;
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
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--kk-accent-2);
            cursor: pointer;
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
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 59, 47, 0.4);
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
        
        .back-link {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-link a {
            color: var(--kk-accent-2);
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link a:hover {
            color: var(--kk-accent);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="logo">
                            <i class="fas fa-key"></i>
                        </div>
                        <h2 class="auth-title">Change Password</h2>
                        <p class="auth-subtitle">Update your account password</p>
                        
                        <?php if(isset($_GET['error'])): ?>
                        <div class="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(isset($_GET['success'])): ?>
                        <div class="alert success">
                            <i class="fas fa-check-circle me-2"></i>
                            Password changed successfully!
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="auth-process.php">
                            <input type="hidden" name="action" value="change_password">
                            
                            <div class="form-group">
                                <i class="fas fa-lock form-icon"></i>
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password" required>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('current_password')"></i>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-key form-icon"></i>
                                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password" required minlength="8" onclick="showPasswordInfo()">
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('new_password')"></i>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-key form-icon"></i>
                                <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password" required>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('confirm_new_password')"></i>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </form>
                        
                        <div class="back-link">
                            <a href="index.php"><i class="fas fa-arrow-left me-2"></i>Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            const newPassword = document.querySelector('input[name="new_password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_new_password"]').value;
            
            // Password strength validation
            if (newPassword.length < 8 || !/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword)) {
                e.preventDefault();
                alert('New password must meet all requirements!');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New passwords do not match!');
            }
        });
    </script>
</body>
</html>