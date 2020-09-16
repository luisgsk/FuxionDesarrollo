<?php if ($datos["pais"] == 'US' || $datos["pais"] == 'us'){ ?>
<nav id="main-nav" >
		<ul style="font-family: 'scandia-bold';font-size: 13px !important;">
      <li style="background-color: #95c11f;color:#fff !important;"><a data-menuanchor="limpia" href="#limpia"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-limpia.png')?>" width="32"> CLEANSING</a></li>

      <li style="background-color: #1f599d;color:#fff !important;"><a data-menuanchor="regenera" href="#regenera"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-regenera.png')?>" width="32"> REGENERATION</a></li>

      <li style="background-color: #ed7004;color:#fff !important;"><a data-menuanchor="revitaliza" href="#revitaliza"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-revitaliza.png')?>" width="32"> REVITALIZATION</a></li>

      <li style="background-color: #009d7b;color:#fff !important;"><a data-menuanchor="inmunologica" href="#inmunologica"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-inmuno.png')?>" width="32"> IMMUNE SUPPORT</a></li>

			<li style="background-color: #1fb7ee;color:#fff !important;"><a data-menuanchor="controlpeso" href="#controlpeso"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-peso.png')?>" width="32"> WEIGHT MANAGEMENT</a></li>

			<li style="background-color: #a3137b;color:#fff !important;"><a data-menuanchor="antiedad" href="#antiedad"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-antiedad.png')?>" width="32"> ANTI-AGE</a></li>

			<li style="background-color: #e42313;color:#fff !important;"><a data-menuanchor="vigormental" href="#vigormental"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-vigormental.png')?>" width="32"> MENTAL POWER</a></li>

			<li style="background-color: #7c909b;color:#fff !important;"><a data-menuanchor="sport" href="#sport"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-sport.png')?>" width="32"> SPORT PERFORMANCE</a></li>
		</ul>
	</nav>
<?php }/*End if US*/ else{ ?>
<nav id="main-nav" >
		<ul style="font-family: 'scandia-bold';font-size: 13px !important;">
      <li id="lilimpia" style="background-color: #95c11f;color:#fff !important;"><a data-menuanchor="limpia" href="#limpia"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-limpia.png')?>" width="32"> LIMPIA</a></li>

      <li id="liregenera" style="background-color: #1f599d;color:#fff !important;"><a data-menuanchor="regenera" href="#regenera"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-regenera.png')?>" width="32"> REGENERA</a></li>

      <li id="lirevitaliza" style="background-color: #ed7004;color:#fff !important;"><a data-menuanchor="revitaliza" href="#revitaliza"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-revitaliza.png')?>" width="32"> REVITALIZA</a></li>

      <li id="liinmunologica" style="background-color: #009d7b;color:#fff !important;"><a data-menuanchor="inmunologica" href="#inmunologica"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-inmuno.png')?>" width="32"> INMUNOLÓGICA</a></li>

			<li id="licontrolpeso" style="background-color: #1fb7ee;color:#fff !important;"><a data-menuanchor="controlpeso" href="#controlpeso"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-peso.png')?>" width="32"> CONTROL DE PESO</a></li>

			<li id="liantiedad" style="background-color: #a3137b;color:#fff !important;"><a data-menuanchor="antiedad" href="#antiedad"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-antiedad.png')?>" width="32"> ANTI EDAD</a></li>

			<li id="livigormental" style="background-color: #e42313;color:#fff !important;"><a data-menuanchor="vigormental" href="#vigormental"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-vigormental.png')?>" width="32"> VIGOR MENTAL</a></li>

			<li id="lisport" style="background-color: #7c909b;color:#fff !important;"><a data-menuanchor="sport" href="#sport"  class="click-menu" style="color:#fff !important;"><img src="<?php echo asset('images/icons/icon-sport.png')?>" width="32"> SPORT</a></li>
		</ul>
	</nav>
<?php }//end else ?>