<?php

// no direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');

$team_members = $params->get('team');
$cacheFolder = JURI::base(true).'/cache/';
$modID = $module->id;
$modPath = JURI::base(true).'/modules/mod_hg_team/';
$document = JFactory::getDocument(); 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$perrow = $params->get('perrow', 4);
$grayscale = $params->get('grayscale', 1);
?>
<div class="row">
<?php
if($team_members) {
	$i = 0;
	$countTM = count($team_members->vals);
	foreach($team_members->vals as $k => $v) {
		
		$img = $team_members->img[$k];
		$thumbImg = ModHgTeamHelper::createThumb($img, 270, 270);
		$thumb = JURI::base(true).'/cache/'.$thumbImg;
		if($grayscale):
		$grThumbImg = ModHgTeamHelper::createGrayscaleThumb($thumbImg, 'grayScale');
		$grThumb = JURI::base(true).'/cache/'.$grThumbImg;
		endif;
		$title = $team_members->title[$k];
		$position = $team_members->position[$k];
		$desc = $team_members->desc[$k];
		$contact = $team_members->contact[$k];
		echo $grthumb;
echo '
<div class="span'.(12/$perrow).'">
	<div class="team_member">
		<a href="'.$img.'" class="grayHoverImg" rel="prettyPhoto">
			<img src="'.$thumb.'" alt="'.$title.'">
			'.($grayscale ? '<img src="'.$grThumb.'" class="grayimage" alt="">':'').'
		</a>
		<h4>'.$title.'</h4>
		<h6>'.$position.'</h6>
		<div class="details">
			<div class="desc">
				<p>'.$desc.'</p>
				'.ModHgTeamHelper::prepare($contact).'
			</div>
		</div>
	</div><!-- end team_member -->
</div>
';
	
		$fin = '</div><!-- end row -->'."\n";
		$fin .= '<div class="row">';
		
		if(($i+1) % $perrow == 0){ echo $fin;} 
		
		if(($i+1) == $countTM) echo '</div><!-- end rowend -->';
	
		$i++;
		
	} // end foreach

} else {
	echo 'Load the member info first!';	
}
?>
