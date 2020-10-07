<style>
          .column {
  float: left;
  width: 33.33%;
}
.column img {
  width: 70% !important;
}

/* Clear floats after the columns */
.rowx:after {
  content: "";
  display: table;
  clear: both;
}

.icon-modal {
  width: 5vw !important;
}
br {
  content: "";
  margin: 2em;
  display: block;
  font-size: 24%;
}
        </style>


<?php
$i = 1;
foreach ($productos as $key => $value) {
?>


<div class="modal fade" id="<?php echo strtolower(str_replace(" ", "-", str_replace("+","X",str_replace("/","-",str_replace("&","",$value->nombre))))); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo strtolower(str_replace(" ", "-", $value->nombre)); ?>" aria-hidden="true" >
  <div class=" modal-dialog modal-lg " role="dialog">
    <div class="modal-content ">
      <div class="modal-body" >
        <!-- icons-->
        <div class="rowx">
        <?php
        if ($datos["pais"] == 'us' || $datos["pais"] == 'US'){
            $icon_info  = asset("images/icons/moreinfo.png");
            $icon_tabla = asset("images/icons/nutritional-table.png");
          }else{
            $icon_info  = asset("images/icons/mas-info-v2.png");
            $icon_tabla = asset("images/icons/tabla.png");
          }
        //Video
        if($value->link_video != null || $value->link_video != ""){
          echo '<div class="column">
          <a href="'.$value->link_video.'" target="_blank">
          <img class="icon-modal" src="'.asset("images/icons/video.png").'">
          </a>
          </div>';
        }

        //Modo uso
        if($value->link_modo_uso != null || $value->link_modo_uso != ""){
          echo '<div class="column">
          <a href="'.$value->link_modo_uso.'" target="_blank">
          <img class="icon-modal"  src="'.$icon_info.'">
          </a>
          </div>';
        }

        //Tabla Nutricional
        if($value->link_tabla_nutricional != null || $value->link_tabla_nutricional != ""){
          echo '<div class="column">
          <a href="'.$value->link_tabla_nutricional.'" target="_blank">
          <img class="icon-modal"  src="'.$icon_tabla.'">
          </a>
          </div>';
        }
        ?>
      </div>
      <hr>
    <!--Fin icons-->

    <div class="row">
        <div class="col-9">
        <p style="color:#<?php echo $value->color_hex; ?>;" class="scandia-bold"><?php echo $value->slogan_info; ?></p>
        </div>
    </div>
        <!---------------------------------------------------------------------------------------------------------------------------->
        <p class="scandia-regular"> <?php echo $value->ingredientes; ?> </p>

        <p class="scandia-regular"> <?php echo $value->descripcion; ?> </p>

        <p class="scandia-regular" >
          <?php
          /****************************************************************************
            Debido a lo variable del texto de los beneficios, le hago un pre formateo 
            para determinar donde colocar los saltos de lineas y guiones medio para 
            mejor lectura y visualización.
            **************************************************************************/

            $verifico = strpos($value->beneficios_bullet,'-');
            if($verifico !== false){
            /**************************************************************************
              Si ya viene con guion medio, el formateo es más facil:
            **************************************************************************/
              $beneficio_aux1 =   str_replace(':', ':<br>', $value->beneficios_bullet);
                                  echo str_replace('- ', '<br>- ', $beneficio_aux1);
            ///////////////////////////////////////////////////////////////////////////
            }else {
            /**************************************************************************
              Si no viene con guion medio, formateo: 
            **************************************************************************/
          $beneficio_aux1 =   str_replace(':',':<br>',$value->beneficios_bullet);
          $beneficio_aux2 =   str_replace('. ', '<br>- ', $beneficio_aux1);
          $beneficio_aux3 =   str_replace('- -', '-', $beneficio_aux2);
          $beneficio_aux4 =   str_replace('. .', '.', $beneficio_aux3);
                              echo $beneficio_aux4;
          ///////////////////////////////////////////////////////////////////////////
            }

           ?>
        </p>

      <p class="scandia-regular">
        <?php echo str_replace('.', '.<br>', $value->adicionales) ; ?>
      </p>
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
$i++;
}//end foreach
?>