<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #fff0f3;
            padding: 0;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 400px;
            margin: 60px auto 0 auto;
            background: #fff;
            padding: 32px 28px 24px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(201, 24, 74, 0.10);
            border: 2px solid #ffb3c1;
        }
        h2 {
            color: #c9184a;
            text-align: center;
            margin-bottom: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        label {
            color: #590d22;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin: 8px 0 18px 0;
            border-radius: 6px;
            border: 1.5px solid #ffb3c1;
            background: #fff0f3;
            font-size: 1em;
            transition: border 0.2s;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border: 1.5px solid #c9184a;
            outline: none;
        }
        input[type="submit"], button {
            width: 100%;
            padding: 12px 0;
            background: #c9184a;
            color: #fff0f3;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        input[type="submit"]:hover, button:hover {
            background: #a4133c;
        }
        .error {
            color: #c9184a;
            background: #fff0f3;
            border: 1px solid #ffb3c1;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            text-align: center;
        }
        .success {
            color: #198754;
            background: #e6ffed;
            border: 1px solid #b3ffcc;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            text-align: center;
        }
        .signup-link {
            text-align: center;
            margin-top: 18px;
            color: #590d22;
        }
        .signup-link a {
            color: #c9184a;
            text-decoration: underline;
            font-weight: 600;
        }
        .signup-link a:hover {
            color: #a4133c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="margin-bottom:18px; text-align:left;">
            <a href="/online_store/view/home/index.php" style="color:#c9184a; text-decoration:underline; font-weight:600;">
                &#8592; Back to Home
            </a>
        </div>

        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form action="/user/login" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>

        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign up here</a>.
        </div>
    </div>
</body>
</html>
