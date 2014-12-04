<?php
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2013 hogash.com. All rights reserved.
# @license  Commercial License http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die;
?>

<link rel="stylesheet" href="<?php echo $tpath;?>/addons/demo_panel/demo_panel.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tpath;?>/addons/demo_panel/jquery.miniColors.css" type="text/css" />
<script type="text/javascript" src="<?php echo $tpath;?>/addons/demo_panel/demo_panel.js"></script>
<script type="text/javascript" src="<?php echo $tpath;?>/addons/demo_panel/jquery.miniColors.min.js"></script>

<!-- DEMO PANEL - REMOVE IF YOU DON'T USE IT -->
	<div id="demo">

		<div id="options_panel">
		    <div class="options">
				<h4>THEME OPTIONS</h4>
		        <table>
		        	<tr>
		            	<td>
		                    <h5>Header type:</h5>
		                    <select name="header_style" id="header_style">
		                    	<option value="1">Style 1</option>
		                    	<option value="2" selected="selected">Style 2 (default)</option>
		                    	<option value="3">Style 3</option>
		                    	<option value="4">Style 4</option>
		                    </select>
		                </td>
					</tr>
					<tr>
		            	<td>
		                    <h5>Theme Colors:</h5>
		                    <input type="text" name="color1" class="color-picker" size="7" autocomplete="on" value="#cd2122" />
						</td>
					</tr>
					<tr>
						<td>
							<h5>Color suggestions *</h5>
							<ul class="color_suggestions">
								<li style="background-color:#B71010;" title="#B71010"></li>
								<li style="background-color:#74AB00;" title="#74AB00"></li>
								<li style="background-color:#363636;" title="#363636"></li>
								<li style="background-color:#1592CC;" title="#1592CC"></li>
								<li style="background-color:#C72647;" title="#C72647"></li>
								<li style="background-color:#91643B;" title="#91643B"></li>
								<li style="background-color:#13D7FD;" title="#13D7FD"></li>
								<li style="background-color:#51106B;" title="#51106B"></li>
								<li style="background-color:#157A13;" title="#157A13"></li>
								<li style="background-color:#EB540A;" title="#EB540A"></li>
								<li style="background-color:#091A57;" title="#091A57"></li>
								<li style="background-color:#700808;" title="#700808"></li>
							</ul>
							<div class="clear"></div>
							
		                </td>
					</tr>
					<tr>
						<td>
							<h5>THEME</h5>
							<select name="theme_switcher" id="theme_switcher">
								<option value="0" selected="selected">Light (Default)</option>
								<option value="1">Dark</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<div class="boxedrow">
							<?php
								$url = JURI::getInstance()->toString();
								$sep = '?';
								if(strpos($url, '?')) $sep = '&amp;';
								
								if(JRequest::getCmd('boxed') == 1) {
								?>
								<a href="<?php echo $url; ?>">Non-Boxed version</a>
							<?php } else { ?>
								<a href="<?php echo $url; ?><?php echo $sep; ?>boxed=1" target="_blank">Boxed version?</a>
							<?php } ?>
							</div>
							
						</td>
					</tr>

					<tr>
						<td><div class="note">* May not have full accuracy!</div></td>
					</tr>
		        </table>
		       
		    </div>
		    <h3><span class="icon-wrench icon-white"></span></h3>
		</div>

	</div>
<!-- end DEMO PANEL - REMOVE IF YOU DON'T USE IT -->