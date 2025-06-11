<?php
// Cart routes
$router->post('/cart/add', 'CartController@add');
$router->get('/cart', 'CartController@view');
$router->post('/cart/remove', 'CartController@remove');

// Wishlist routes
$router->get('/wishlist', 'WishlistController@index');
$router->post('/wishlist/add', 'WishlistController@add');
$router->post('/wishlist/remove', 'WishlistController@remove');