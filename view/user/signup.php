<?php include __DIR__ . '/../header.php'; ?>

<h1>Sign Up</h1>

<form action="/online_store/public/index.php?url=user/signup" method="POST">
    <label>Username: </label>
    <input type="text" name="username" required><br><br>

    <label>Email: </label>
    <input type="email" name="email" required><br><br>

    <label>Password: </label>
    <input type="password" name="password" required><br><br>

    <label>Shipping Address: </label>
    <textarea name="shippingAddress" required></textarea><br><br>

    <input type="submit" value="Sign Up">
</form>



<p>Already have an account? <a href="/online_store/public/index.php?url=user/showLoginForm">Login here</a>.</p>


<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

<?php include __DIR__ . '/../footer.php'; ?>
