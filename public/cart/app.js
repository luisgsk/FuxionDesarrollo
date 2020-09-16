var nombre_cart;
var precio_cart;
var quitar_cart;

switch (pais_cart){
  case 'us':
  nombre_cart = "Name";
  precio_cart = "Price";
  quitar_cart = "Delete";
  break;
  case 'US':
  nombre_cart = "Name";
  precio_cart = "Price";
  break;
  default:
  nombre_cart = "Nombre";
  precio_cart = "Precio";
  quitar_cart = "Quitar";
  break;
}
$(document).ready(function($) {
    /* Función jQuery para el evento clic en la etiqueta "x" con la clase (.carrito-total)*/
    $('.carrito-total').click(function() {
      //Mostrar los items del carrito
      $('.bolsa').slideToggle();
    });

  });

//SIMPLE CART
//Configuraciones básicas, recuerda tu lo puedas adaptar a tu medida
simpleCart({
  cartColumns: [
      //{ view:'image' , attr:'image', label: "Imagen"}, //obtiene la imagen
      { attr: "name", label: nombre_cart}, //obtiene el nombre
      { view: "currency", attr: "price", label: precio_cart},//obtiene el precio
      { view: "decrement", label: "-"}, //Resta el producto
      { attr: "quantity", label: "Nº"}, //obtiene la cantidad del producto
      { view: "increment", label: "+"}, //Suma el producto
      //{ view: "currency", attr: "total", label: "SubTotal" },// Obtiene el precio total del producto
      { view: "remove", text: '<span class="cd-item-remove cd-img-replace">Remove</span>', label: quitar_cart} //Quita o remueve el producto
  ],

  cartStyle: "table", //puede ser div o table

  checkout: { 
      type: "SendForm",
        url: "https://i.ibrlatam.com/fuxion/desa/public/post.php"
  }

});