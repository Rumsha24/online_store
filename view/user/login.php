<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 5px; }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
<form action="?url=user/login" method="POST">
    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>


    </div>

    
<p>
    Don't have an account? <a href="?url=user/showSignupForm">Sign up here</a>.
</p>
</body>
</html>
