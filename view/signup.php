<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';

    $db = (new Database())->getConnection();

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']);

    // Check if email already exists
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: signup.php");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $db->prepare("INSERT INTO users (username, email, password, shippingAddress) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashedPassword, $address])) {
        // Optionally log the user in automatically:
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: signup.php");
        exit;
    }
}

include __DIR__ . '/header.php';
?>

<style>
    .signup-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(89, 13, 34, 0.1);
        border: 1px solid #ffccd5;
    }

    .signup-title {
        color: #800f2f;
        text-align: center;
        font-size: 2.2em;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
        font-weight: 600;
    }

    .signup-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #ff4d6d, #c9184a);
        border-radius: 4px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: #590d22;
        font-weight: 500;
        font-size: 0.95em;
    }

    .form-group input {
        width: 100%;
        padding: 14px;
        border: 2px solid #ffb3c1;
        border-radius: 10px;
        font-size: 1em;
        transition: all 0.3s ease;
        background-color: #fff0f3;
    }

    .form-group input:focus {
        border-color: #ff4d6d;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 77, 109, 0.2);
        background-color: #ffffff;
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #c9184a, #a4133c);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 10px;
        box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #a4133c, #800f2f);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 25px;
        color: #590d22;
        font-size: 0.95em;
    }

    .login-link a {
        color: #c9184a;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        position: relative;
    }

    .login-link a:hover {
        color: #800f2f;
    }

    .login-link a:after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #ff4d6d;
        transform: scaleX(0);
        transition: transform 0.3s ease;
        transform-origin: right;
    }

    .login-link a:hover:after {
        transform: scaleX(1);
        transform-origin: left;
    }

    .error-message {
        color: #800f2f;
        background: #ffccd5;
        padding: 12px;
        border-left: 4px solid #c9184a;
        border-radius: 6px;
        margin-bottom: 25px;
        text-align: center;
        font-size: 0.95em;
        font-weight: 500;
    }
</style>

<div class="signup-container">
    <h1 class="signup-title">Create Account</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="/online_store/view/signup.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="address">Shipping Address</label>
            <input type="text" id="address" name="address" required>
        </div>

        <button type="submit" class="submit-btn">Sign Up</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="/online_store/view/login.php">Sign In</a>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>


