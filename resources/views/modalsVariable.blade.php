<?php
$i = 1;
foreach ($productos as $key => $value) {
  if($value->is_variable == 1){
            /*===================================================================
              El producto Protein Xoup tiene 3 variables, por lo tanto hago una
              pequeña modificación para que se abra el header y cierre el footer
              correctamente. ya que el resto de productos solo tiene 2 variaciones
              y la lógica está hecha para productos pares.
              ==================================================================*/  
  if($value->sku == 144170){$i = $i-1;/*resto 1 al tercer producto de ProteinXoup para cerrar footer.*/}  
  $nombre_producto = explode('-',$value->nombre);  

            /*========================================================================
              Si $i es impar [Primero de cada producto], abro el header del modal.
              ========================================================================*/
            if ($i%2==0){/*el numero es par*/}else{ 
?>
<!-- ================================================ Header Modal <?php echo $nombre_producto[0].' - '.$value->linea; ?>============================================== -->
            <!-------------------------------------------------------------------
              El id del modal es la constante " select- " más la primera parte
              del nombre del producto. esto gracias al explode con guión medio.
              Se reemplaza espacio en blanco por guión medio.
              ------------------------------------------------------------------>
      <div class="modal fade" id="select-<?php echo str_replace(' ','-',str_replace("+","X",str_replace("/","-",str_replace("&","",$nombre_producto[0])))); ?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class=" modal-dialog modal-lg modal-dialog modal-dialog-centered modal-select" role="dialog">
          <div class="modal-content ">
          <div class="modal-body" >
      <span class="scandia-bold" style="text-align: center !important;">
        <?php if ($datos["pais"] == 'us' || $datos["pais"] == 'US'){
            echo "Select the presentation";
          }else {
            echo "Selecciona la presentación";
          }

          ?>
      </span>
      <hr>
      <?php }// end is impar ?>

        <div class="row">
          <!-- producto -->
            <div class="col-sm simpleCart_shelfItem">
            <span class="item_name" style="display: none;">   <?php    echo $value->nombre.' | '.$value->presentacion;  ?></span>
            <span style="display: none;" class="item_price">  <?php    echo $value->precio;  ?></span>
            <span class="item_number" style="display: none;"> <?php    echo $value->sku;     ?></span>
            <a href="javascript:;" class="item_add">
              <!----------------------------------->
              <button data-dismiss="modal" onclick="setTrazabilizad('<?php echo $service[0]->session_id; ?>','añadirCarrito','prunex1-142626','limpia');this.disabled=true;" type="button" class="btn btn-primary bnt-lg comprar-info-btn scandia-bold" style="font-size:15px!important; "><?php echo $value->nombre.' | '.$value->presentacion; ?></button>
            <!----------------------------------->
            </a>
            <br>
            <?php 
                /*========================================================================
                  Verifico si el precio tiene punto o no, para mostrar correctamente el
                  decimal cuando corresponda.
                  ========================================================================*/
            $punto = strpos($value->precio, '.'); ?>
            <span class="symbol-precio-modal">    <?php echo  $value->simbolo?>   </span> 
            <?php if($punto != false){ $precio = explode('.', $value->precio); ?>
            <span class="precio-modal">           <?php echo $precio[0]; ?>       </span> 
            <span class="precio-decimal-modal">   <?php echo '.'.$precio[1];?>    </span>
            <?php }//end is con punto 
            else { echo '<span class="precio-modal">'.str_replace(',','.',number_format($value->precio)).'</span>'; }?>
            <hr>
          </div>
        </div>

<?php 
            /*========================================================================
              Si $i es par [Segundo de cada producto], cierro el footer del modal.
              ======================================================================*/
        if ($i%2==0 && $value-> sku != 144171/*En el segundo de los tre producto ProteinXoup no cierro footer*/){ ?>
<!-- ================================================Footer Modal <?php echo $nombre_producto[0] ?>============================================== -->
      </div> <!-- end modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal"><span>
          <?php if ($datos["pais"] == 'us' || $datos["pais"] == 'US'){
            echo "Close";
          }else {
            echo "Cerrar";
          }

          ?>
        </span></button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
<?php
}//end is par
$i++;
}//end is variable
}//end foreach
?>