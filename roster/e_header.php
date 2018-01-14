<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/

if (!defined('e107_INIT')) { exit; }


if(USER_AREA) // prevents inclusion of JS/CSS/meta in the admin area.
{
	//e107::js('roster', 'roster.js');      // loads e107_plugins/roster/js/roster.js on every page.
	//e107::js('roster', '/js/jquery-latest.js');
	e107::css('roster', 'roster.css');    // loads e107_plugins/roster/css/roster.css on every page
	e107::meta('keywords', 'roster,rsystem,prescom,c-com,ccom,clonecom,awards,ranks');   // sets meta keywords on every page.
	
/*	$damnScript = "<script>
						var cacheData;
						var data = $('#bottom-bar').html();
						var auto_refresh = setInterval(
						function ()
						{
							$.ajax({
								url: '/e107_plugins/roster/roster_shortcodes.php',
								type: 'POST',
								data: data,
								dataType: 'html',
								success: function(data) {
									if (data !== cacheData){
										//data has changed (or it's the first call), save new cache data and update div
										cacheData = data;
										$('#bottom-bar').html(data);
									}         
								}
							})
						}, 60000); // check every 60000 milliseconds (1 Min)
				</script>";
	$damnScript = '<script langauge="javascript">
                var counter = 0;
                window.setInterval("refreshDiv()", 60000);
                function refreshDiv(){
                    counter = counter + 1;
                    document.getElementById("test").innerHTML = "Testing " + counter;
                }
            </script> ';
	return $damnScript;*/
}



?>