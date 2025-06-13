<!-- Order Page: Recording a Sale -->
<h2 style="color:#c9184a; text-align:center;">Place Your Order</h2>
<form action="process_order.php" method="POST" style="max-width:400px; margin:0 auto; background:#fff0f3; padding:24px; border-radius:10px; border:1.5px solid #c9184a;">
  <label for="customer_name" style="font-weight:bold;">Customer Name:</label><br>
  <input type="text" id="customer_name" name="customer_name" required style="width:100%; margin-bottom:12px;"><br>

  <label for="product" style="font-weight:bold;">Product:</label><br>
  <select id="product" name="product" required style="width:100%; margin-bottom:12px;">
    <option value="">Select a product</option>
    <option value="Jean Paul Gaultier">Jean Paul Gaultier</option>
    <option value="Versace">Versace</option>
    <option value="Giorgio Armani">Giorgio Armani</option>
    <option value="D&G">D&G</option>
    <option value="Calvin Klein">Calvin Klein</option>
  </select><br>

  <label for="quantity" style="font-weight:bold;">Quantity:</label><br>
  <input type="number" id="quantity" name="quantity" min="1" required style="width:100%; margin-bottom:12px;"><br>

  <label for="address" style="font-weight:bold;">Shipping Address:</label><br>
  <textarea id="address" name="address" required style="width:100%; margin-bottom:12px;"></textarea><br>

  <button type="submit" style="background:#c9184a; color:#fff; border:none; padding:10px 20px; border-radius:5px; font-weight:bold;">Submit Order</button>
</form>