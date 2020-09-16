<?php if (in_array('NUTRICIÓN Y REGENERACIÓN', $lineas_pais)) { ?>
	<!-- ========================= Section 1 regenera======================= -->
	<div class="section" id="regenera" data-anchor="regenera">

		<!-- ========================= regenera Slide 1 [Portada principal]======================= -->
		<div class="slide" id="regenera_slide1">
			<!-- contenido-->
		</div><!-- end Slide 1 familia 1 -->

		<!-- ========================= regenera Slide 2 ======================= -->
		<?php $destacado = array();
		foreach ($productos as $key => $value) {
			if ($value->linea == 'NUTRICIÓN Y REGENERACIÓN' && $value->is_destacado == 1) {
				array_push($destacado, $value);
			} //end if
		} //end foreach
		?>
		<div class="slide" id="regenera_slide2">
			<div class="container-fluid simpleCart_shelfItem">
				<div class="comprar-info-abajo-slide" style="">

					<a href="javascript:;" class="item_add"><button onclick="setTrazabilizad('<?php echo $service[0]->session_id; ?>','añadirCarrito','<?php echo str_replace("+", "X", $destacado[0]->nombre) . "-" . $destacado[0]->sku; ?>','<?php echo $destacado[0]->linea; ?>');this.disabled=true;" type="button" class="btn btn-primary bnt-lg comprar-info-btn"><?php if ($datos["pais"] == 'US' || $datos["pais"] == 'us') {
																																																																																												echo "BUY";
																																																																																											} else {
																																																																																												echo "COMPRAR";
																																																																																											} ?></button></a>

					<span style="display: none;" class="item_price"> <?php echo $destacado[0]->precio; ?></span>
					<span class="item_number" style="display: none;"> <?php echo $destacado[0]->sku;    ?></span>
					<span class="item_name" style="display: none;"> <?php echo $destacado[0]->nombre; ?></span>

					<img onclick="setTrazabilizad('<?php echo $service[0]->session_id; ?>','verInfo','<?php echo $destacado[0]->nombre; ?>','<?php echo $destacado[0]->linea; ?>');verInfo('<?php echo strtolower(str_replace(" ", "-", str_replace("+", "X", str_replace("/", "-", str_replace("&", "", str_replace("&", "", $destacado[0]->nombre)))))); ?>');" src="<?php echo asset('images/icons/icon-info.png') ?>" class="comprar-info-icon">
				</div>
			</div><!-- end container fluid -->
		</div><!-- end Slide 2 familia 1 -->

		<!-- *******************
	 	  PRODUCTOS 
	 ******************* -->

		<?php
		$i = 1;
		foreach ($productos as $key => $value) {

			if ($value->linea == 'NUTRICIÓN Y REGENERACIÓN' && strlen($value->orden_str) <= 3) {
				/******************************************
				Verifico valor de $i para saber cuando abrir
				y cerrar el div Slide. Manteniendo asi
				la visualizacion de productos de 2 en 2.
				 ******************************************/

				if ($i % 2 == 0) {
					//echo "el $numero es par";
				} else {
					//echo "el $numero es impar";
					echo '<div class="slide">';
				}
		?>


				<div class="row simpleCart_shelfItem">
					<!-- row producto 1 -->
					<div class="col-sm ">
						<?php
						/********************************************
					Si el producto a imprimir es par (Abajo)
					coloco la franja de información encima 
					de la imagen.
						 ********************************************/
						if ($i % 2 == 0) {
							//echo "el $numero es par";
						?>
							<!-- FRANJA SEGUNDO PRODUCTO VA ENCIMA DE LA IMAGEN -->
							<div class="franja-producto">
								<div class="row div-titulo-producto">
									<!-- row titulo-producto -->

									<div class="col col-sm-2"></div><!-- cuadre de separacion izquierda -->

									<div class="col-sm">
										<!-- col para titulo producto -->


										<?php
										/*if(strlen($value->nombre) > 13 ){
				 				echo '<span class="titulo-productos item_name" style=" font-size: 3vw !important;">';
				 				echo str_replace('-', '-<br>', $value->nombre);
				 				echo '</span><br>';
				 			}else {
				 				echo '<span class="titulo-productos item_name">';
				 				echo $value->nombre;
				 				echo '</span><br>';
				 			}*/
										$nombre_producto = explode('-', $value->nombre);
										echo '<span class="titulo-productos item_name">';
										echo $nombre_producto[0];
										echo '</span><br>';

										?>


										<span class="subtitulo-productos"><?php echo $value->presentacion . ' / CV:' . $value->puntos; ?></span>
									</div><!-- end col titulo producto -->

									<div class="col-sm div-precio">
										<!-- col precio -->
										<?php $punto = strpos($value->precio, '.'); 														  ?>
										<span class="symbol-precio"> <?php echo  $value->simbolo ?>
										</span>
										<span class="precio"> <?php if ($punto != false) {
																	$precio = explode('.', $value->precio);
																	echo $precio[0];
																} else {
																	echo str_replace(",", ".", number_format($value->precio));
																}

																?></span>

										<span class="precio-decimal"> <?php if ($punto != false) {
																			echo '.' . $precio[1];
																		} else {
																			echo '';
																		}
																		?> </span>

										<!--simpleCart-->
										<span style="display: none;" class="item_price"><?php echo $value->precio; ?></span>
										<span class="item_number" style="display: none;"><?php echo $value->sku; ?></span>
										<!--simpleCart-->
									</div><!-- end col precio -->

								</div><!-- end row titulo producto-->
							</div><!-- end franja producto -->
						<?php
						} else {
							//echo "el $numero es impar";
						}
						?>

						<img data-src="<?php echo asset('images/productos/' . $datos["pais"] . '/' . $value->linea . '/' . str_replace('+', 'X', $value->imagen) . '') ?>" class="rounded mx-auto d-block img-fluid img-producto-arriba lazyload">

						<div class="comprar-info-arriba">
							<!--------------------------------------------------------------------->
							<?php if ($value->is_variable == 1) {
								$nombre_variable = explode('-', str_replace("+", "X", str_replace("/", "-", str_replace("&", "", $value->nombre)))); ?>
								<!--------------------------------------------------------------------->
								<a><button onclick="selectproduct('select-<?php echo str_replace(' ', '-', $nombre_variable[0]); ?>');" type="button" class="btn btn-primary bnt-lg comprar-info-btn"><?php if ($datos["pais"] == 'US' || $datos["pais"] == 'us') {
																																																			echo "BUY";
																																																		} else {
																																																			echo "COMPRAR";
																																																		} ?></button></a>
								<!--------------------------------------------------------------------->
							<?php } else { ?>
								<!--------------------------------------------------------------------->
								<a href="javascript:;" class="item_add"><button onclick="setTrazabilizad('<?php echo $service[0]->session_id; ?>','añadirCarrito','<?php echo $value->nombre . "-" . $value->sku; ?>','<?php echo $value->linea; ?>');this.disabled=true;" type="button" class="btn btn-primary bnt-lg comprar-info-btn"><?php if ($datos["pais"] == 'US' || $datos["pais"] == 'us') {
																																																																																				echo "BUY";
																																																																																			} else {
																																																																																				echo "COMPRAR";
																																																																																			} ?></button></a>
								<!--------------------------------------------------------------------->
							<?php } //end else 
							?>
							<!--------------------------------------------------------------------->
							<img onclick="setTrazabilizad('<?php echo $service[0]->session_id; ?>','verInfo','<?php echo $value->nombre . "-" . $value->sku; ?>','<?php echo $value->linea; ?>');verInfo('<?php echo strtolower(str_replace(" ", "-", str_replace("+", "X", str_replace("/", "-", str_replace("&", "", $value->nombre))))); ?>');" src="<?php echo asset('images/icons/icon-info.png') ?>" class="comprar-info-icon">
						</div><!-- end comprar info arriba -->

						<?php
						/********************************************
					Si el producto a imprimir es impar (Arriba)
					coloco la franja de información debajo 
					de la imagen.
						 ********************************************/
						if ($i % 2 == 0) {
							//echo "el $numero es par";
						} else {
							//echo "el $numero es impar";
						?>
							<!-- FRANJA PRIMER PRODUCTO VA DEBAJO DE LA IMAGEN -->
							<div class="franja-producto">
								<div class="row div-titulo-producto">
									<!-- row titulo-producto -->

									<div class="col col-sm-2"></div><!-- cuadre de separacion izquierda -->

									<div class="col-sm">
										<!-- col para titulo producto -->


										<?php
										/*if(strlen($value->nombre) > 13 ){
				 				echo '<span class="titulo-productos item_name" style=" font-size: 3vw !important;">';
				 				echo str_replace('-', '-<br>', $value->nombre);
				 				echo '</span><br>';
				 			}else {
				 				echo '<span class="titulo-productos item_name">';
				 				echo $value->nombre;
				 				echo '</span><br>';
				 			}*/
										$nombre_producto = explode('-', $value->nombre);
										echo '<span class="titulo-productos item_name">';
										echo $nombre_producto[0];
										echo '</span><br>';

										?>


										<span class="subtitulo-productos"><?php echo $value->presentacion . ' / CV:' . $value->puntos; ?></span>
									</div><!-- end col titulo producto -->

									<div class="col-sm div-precio">
										<!-- col precio -->
										<?php $punto = strpos($value->precio, '.'); 														  ?>
										<span class="symbol-precio"> <?php echo  $value->simbolo ?>
										</span>
										<span class="precio"> <?php if ($punto != false) {
																	$precio = explode('.', $value->precio);
																	echo $precio[0];
																} else {
																	echo str_replace(",", ".", number_format($value->precio));
																}

																?></span>

										<span class="precio-decimal"> <?php if ($punto != false) {
																			echo '.' . $precio[1];
																		} else {
																			echo '';
																		}
																		?> </span>

										<!--simpleCart-->
										<span style="display: none;" class="item_price"><?php echo $value->precio; ?></span>
										<span class="item_number" style="display: none;"><?php echo $value->sku; ?></span>
										<!--simpleCart-->
									</div><!-- end col precio -->

								</div><!-- end row titulo producto-->
							</div><!-- end franja producto -->
						<?php
						}
						?>

					</div><!-- end col producto 1 -->
				</div><!-- end row producto 1 -->
		<?php
				/*************************************************
				Ciero el DIV slide cuado la cantidad de productos
				sea par (2 en 2)
				 *************************************************/
				if ($i % 2 == 0) {
					//echo "el $numero es par";
					echo '</div>'; //end div slide
				} else {
					//echo "el $numero es impar";
					/*Division de producto va siempre bebajo
			    del primer producto*/
					echo '<div class="divison-productos"></div>';
				}

				$i++;
			} //end if familia				
		} //end foreach

		if ($i % 2 == 0) {
			/*************************************************
				En caso de que el total de productos de la linea
				sea un numero impar, el foreach le sumara 1 dejando
				el numero par por lo que la condicion anterior
				no cerrará el div y lo tengo que cerrar de esta
				manera.
			 *************************************************/
			//es par
			echo '</div>'; //end div slide
		} else {
			//es impar
		}

		?>
	</div><!-- end section regenera --->
<?php } //end if in array
else {
	echo '<script>$("#liregenera").hide();</script>';
} ?>