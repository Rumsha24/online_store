<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo "Invalid order.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - Noire Essence</title>
    <style>
        :root {
            --deep-red: #590D22;
            --rich-red: #800F2F;
            --vibrant-red: #A4133C;
            --primary-red: #C9184A;
            --bright-pink: #FF4D6D;
            --soft-pink: #FF758F;
            --light-pink: #FF8FA3;
            --pale-pink: #FFB3C1;
            --very-pale-pink: #FFCCD5;
            --almost-white: #FFF0F3;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:wght@700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--almost-white);
            padding: 20px;
            color: var(--deep-red);
            line-height: 1.6;
        }
        
        .success-container {
            max-width: 800px;
            margin: 60px auto;
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(89, 13, 34, 0.08);
            border: 1px solid var(--very-pale-pink);
            text-align: center;
        }
        
        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-red);
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
        }
        
        h2:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--bright-pink);
        }
        
        p {
            font-size: 1.2rem;
            margin: 30px 0;
            color: var(--rich-red);
        }
        
        .order-id {
            font-weight: 600;
            color: var(--vibrant-red);
        }
        
        .btn {
            background: var(--primary-red);
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
            margin-top: 20px;
        }
        
        .btn:hover {
            background: var(--vibrant-red);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .confirmation-icon {
            color: var(--bright-pink);
            font-size: 4rem;
            margin-bottom: 20px;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        @media (max-width: 768px) {
            .success-container {
                padding: 30px 20px;
                margin: 30px auto;
            }
            
            h2 {
                font-size: 2rem;
            }
            
            p {
                font-size: 1.1rem;
            }
            
            .btn {
                padding: 14px 24px;
                font-size: 1rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<div class="success-container">
    <div class="confirmation-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2>Your Fragrance Order Is Complete!</h2>
    <p>Your order <span class="order-id">(ID: <?= htmlspecialchars($orderId) ?>)</span> has been successfully placed.</p>
    <p>We've sent a confirmation to your email. Your exquisite scents will be carefully packaged and shipped soon.</p>
    <a href="receipt.php?order_id=<?= htmlspecialchars($orderId) ?>" class="btn">View Receipt</a>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>