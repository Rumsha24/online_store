
// In your routing file (e.g., app/core/Router.php)
$router->get('/wishlist', 'WishlistController@index');
$router->post('/wishlist/add', 'WishlistController@add');
$router->post('/wishlist/remove', 'WishlistController@remove');
$router->get('/wishlist/status', 'WishlistController@status');