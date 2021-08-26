<!DOCTYPE html>
<html>
<head>
	<title>Mi Mapa</title>
</head>
<body>
	<?php

		if ( isset($_GET['inicio']) && isset($_GET['fin']) && isset($_GET['consumo'])&& isset($_GET['precio']) ){

			
			$kml=number_format ( (100/$_GET['consumo']) ,2 );
				echo "<a class='rp-widget-link' rel='noopener' target='_blank' data-currency='MXN' data-measure='metric' data-css='https://www.mejoresrutas.com/widget/v1/widget.css?pc=c20c00&bc=efefef&tc=000000' data-default-from='".$_GET['inicio']."' data-hide-from data-default-to='".$_GET['fin'] ."' data-hide-to  data-default-fuel-consumption='".$kml."' data-default-fuel-price='".$_GET['precio']."'  data-default-speed-limit-motorway='110' data-default-speed-limit-other='90' data-show-result-length data-show-result-driving-time data-show-result-fuel-amount data-show-result-fuel-cost data-show-result-map data-show-result-scheme data-only-countries='MX' data-prefer-countries='MX' href='https://www.mejoresrutas.com/' ></a><script async='async' src='https://www.mejoresrutas.com/widget/v1/client.js'></script>";
				/*/echo "
					<a  class='rp-widget-link' data-calculate-instantly data-default-from='".$_GET['hola']."' data-default-to='".$_GET['mundo']."' rel='noopener' target='_blank' data-currency='MXN' data-show-fuel-calc data-default-fuel-consumption='10' data-default-fuel-price='20.18' data-measure='metric' data-css='https://www.mejoresrutas.com/widget/v1/widget.css?pc=ff1606&bc=efefef&tc=000000'  data-show-result-length data-show-result-driving-time data-show-result-fuel-amount data-show-result-fuel-cost data-show-result-customized-cost data-show-result-map data-show-result-scheme href='https://www.mejoresrutas.com/' style='display: none' ></a><script async='async' src='https://www.mejoresrutas.com/widget/v1/client.js'></script>
						data-show-speed-profile
						data-show-fuel-calc
				";/*/
		//	echo "<script language='javascript'>alert($_GET['hola']);</script>";


		}else{
			


			echo "<script language='javascript'>alert('no hay get');</script>";
		}
	?>	
<!--
	<a class="rp-widget-link" rel="noopener" target="_blank" data-currency="MXN" data-measure="metric" data-css="https://www.mejoresrutas.com/widget/v1/widget.css?pc=c20c00&bc=efefef&tc=000000" data-default-from="Acambay (México)" data-hide-from data-default-to="Guadalajara (Jalisco, México)" data-hide-to data-show-fuel-calc data-default-fuel-consumption="10" data-default-fuel-price="20.18" data-show-speed-profile data-default-speed-limit-motorway="110" data-default-speed-limit-other="90" data-show-result-length data-show-result-driving-time data-show-result-fuel-amount data-show-result-fuel-cost data-show-result-map data-show-result-scheme data-only-countries="MX" data-prefer-countries="MX" href="https://www.mejoresrutas.com/">https://www.mejoresrutas.com</a><script async="async" src="https://www.mejoresrutas.com/widget/v1/client.js"></script>

	<a class="rp-widget-link" rel="noopener" target="_blank" data-currency="MXN" data-measure="metric" data-css="https://www.mejoresrutas.com/widget/v1/widget.css?pc=c20c00&bc=efefef&tc=000000" data-default-from="Acambay (México)" data-default-to="Guadalajara (Jalisco, México)" data-show-fuel-calc data-default-fuel-consumption="10" data-default-fuel-price="20.18" data-show-speed-profile data-default-speed-limit-motorway="110" data-default-speed-limit-other="90" data-show-result-length data-show-result-driving-time data-show-result-fuel-amount data-show-result-fuel-cost data-show-result-map data-show-result-scheme data-only-countries="MX" data-prefer-countries="MX" href="https://www.mejoresrutas.com/">https://www.mejoresrutas.com</a><script async="async" src="https://www.mejoresrutas.com/widget/v1/client.js"></script>
-->
	
	<?php
	// data-show-via  data-show-speed-profile  
	?>
</body>
</html>

