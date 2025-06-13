<?php
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // First, clear existing comments
    $db->exec("DELETE FROM comments");
    
    // Then clear existing cart items
    $db->exec("DELETE FROM cart");
    
    // Finally clear existing products
    $db->exec("DELETE FROM products");

    // Products data
    $products = [
    [
        'description' => 'Velvet Aurora - A radiant blend of violet, musk, and soft amber for a dreamy evening.',
        'image' => '../images/1.jpg',
        'price' => 99.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Midnight Peony - Peony and blackcurrant wrapped in a mysterious vanilla base.',
        'image' => '../images/2.jpg',
        'price' => 120.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Amber Whisper - Warm amber, sandalwood, and a hint of fig for a cozy embrace.',
        'image' => '../images/3.jpg',
        'price' => 88.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Celestial Bloom - A celestial bouquet of jasmine, neroli, and white tea.',
        'image' => '../images/4.jpg',
        'price' => 135.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Rosewood Reverie - Rose, cedar, and a touch of citrus for a modern classic.',
        'image' => '../images/5.jpg',
        'price' => 105.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Golden Mirage - A sparkling blend of saffron, pear, and golden woods.',
        'image' => '../images/6.jpg',
        'price' => 112.50,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Lush Serenity - Green tea, bamboo, and lotus for a calming escape.',
        'image' => '../images/7.png',
        'price' => 89.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Moonlit Jasmine - Night-blooming jasmine with hints of citrus and musk.',
        'image' => '../images/25.jpg',
        'price' => 75.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Saffron Veil - Saffron, rose, and creamy sandalwood for a rich finish.',
        'image' => '../images/11.jpeg',
        'price' => 120.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Petal Noir - Dark rose, patchouli, and black pepper for a bold statement.',
        'image' => '../images/12.png',
        'price' => 130.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Azure Muse - Aquatic notes, blue lotus, and driftwood for a fresh vibe.',
        'image' => '../images/14.jpeg',
        'price' => 108.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Blush Ember - Pink pepper, rose, and smoky woods for a warm embrace.',
        'image' => '../images/19.jpg',
        'price' => 118.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Opal Essence - Iris, white musk, and pear for a luminous signature.',
        'image' => '../images/20.jpg',
        'price' => 95.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Wild Iris - Wild iris, bergamot, and vetiver for a fresh, green scent.',
        'image' => '../images/21.png',
        'price' => 89.00,
        'shippingCost' => 0.00
    ],
    [
        'description' => 'Enchanted Fig - Fig, coconut, and tonka bean for a sweet, creamy finish.',
        'image' => '../images/22.png',
        'price' => 122.00,
        'shippingCost' => 0.00
    ]
];

// Insert products
$query = "INSERT INTO products (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($query);

foreach ($products as $product) {
    $stmt->execute([
        $product['description'],
        $product['image'],
        $product['price'],
        $product['shippingCost']
    ]);
}

echo "Fragrance products inserted successfully!";

    // Insert products
    $query = "INSERT INTO products (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    foreach ($products as $product) {
        $stmt->execute([
            $product['description'],
            $product['image'],
            $product['price'],
            $product['shippingCost']
        ]);
    }

    echo "Products inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 