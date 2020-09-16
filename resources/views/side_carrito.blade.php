<!-- CONTENIDO CARRITO -->
<div id="cd-cart">
		<!--<h2>Cart</h2>-->
		<div class="simpleCart_items cd-cart-items" style="overflow-y: scroll !important;"></div>
		<!--<ul class="cd-cart-items">

			<li>
				<span class="cd-qty">1x</span> Product Name
				<div class="cd-price">$9.99</div>
				<a href="#0" class="cd-item-remove cd-img-replace">Remove</a>
				
			</li>

			<li>
				<span class="cd-qty">2x</span> Product Name
				<div class="cd-price">$19.98</div>
				<a href="#0" class="cd-item-remove cd-img-replace">Remove</a>
			</li>

			<li>
				<span class="cd-qty">1x</span> Product Name
				<div class="cd-price">$9.99</div>
				<a href="#0" class="cd-item-remove cd-img-replace">Remove</a>
			</li>
		</ul>--> <!-- cd-cart-items -->
		
		<div class="cd-cart-total">
			<p id="cartempty" style="font-family: 'Scandia-Regular' !important;font-weight: bold;font-size: 15px;text-align: center;margin-top: 15px !important;"></p>
			<p style="font-family: 'Scandia-Regular' !important;font-weight: bold;font-size: 15px;" class="carrito">Total <!--<span class="simpleCart_quantity"></span>--> <span class="simpleCart_total"></span></p>
		</div> <!-- cd-cart-total -->

		<hr>
		<a id="seguircomprando" class="checkout-btn" style="font-family: 'Scandia-Regular' !important;font-weight: bold;font-size: 15px !important; background-color: #0089cf;margin-bottom: 6px;"> <?php if ($datos["pais"] == 'us' || $datos["pais"] == 'US'){
            echo "Continue shopping";
          }else {
            echo "Seguir comprando";
          }

          ?></a>
		<a href="#0" id="checkout" class="checkout-btn simpleCart_checkoutttt" style="font-family: 'Scandia-Regular' !important;font-weight: bold;font-size: 15px !important;margin-bottom: 300px;"><?php if ($datos["pais"] == 'us' || $datos["pais"] == 'US'){
            echo "Proceed to checkout";
          }else {
            echo "Finalizar compra";
          }

          ?></a>
		
		<!--<p class="cd-go-to-cart"><a class="boton simpleCart_empty" href="javascript:void(0)" style="font-family: 'Scandia-Regular' !important;font-weight: bold;font-size: 35px;">Vaciar carrito</a></p>-->
	</div> <!-- cd-cart -->