<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$title = $params->get('title');
$type = $params->get('type');
$width = $params->get('width', 180);
$align = $params->get('align', 'none');
$margin = $params->get('margin', 0);

$mecard_name = $params->get('mecard_name');
$mecard_address = $params->get('mecard_address');
$mecard_tel1 = $params->get('mecard_tel1');
$mecard_tel2 = $params->get('mecard_tel2');
$mecard_tel3 = $params->get('mecard_tel3');
$mecard_tel4 = $params->get('mecard_tel4');
$mecard_email = $params->get('mecard_email');
$mecard_url = $params->get('mecard_url');

$text = $params->get('text');

$url = $params->get('url');

$call_country_code = $params->get('call_country_code');
$call_area_code = $params->get('call_area_code');
$call_telephone = $params->get('call_telephone');

$sms_country_code = $params->get('sms_country_code');
$sms_area_code = $params->get('sms_area_code');
$sms_telephone = $params->get('sms_telephone');
$sms_text = $params->get('sms_text');

if($title != '')
	$title = '<h6>'.$title.'</h6>';

$style = ' style="float:'.$align.'; margin:'.$margin.'; width:'.($width+20).'px; "';

$data = 'http://api.qrserver.com/v1/create-qr-code/?data=';

switch($type) {
	case "text":
		$data .= urlencode($text);
	break;
	
	case "url":
		$data .= urlencode($url);
	break;
	
	case "call":
		$data .= urlencode('TEL:'.$call_country_code.$call_area_code.$call_telephone);
	break;
	
	case "sms":
		$data .= urlencode('SMSTO:'.$sms_country_code.$sms_area_code.$sms_telephone.':'.$sms_text);
	break;
	
	case "mecard":

		$mecard_data = '';
		if($mecard_name != '')
			$mecard_data .= 'N:'.$mecard_name.';';
		if($mecard_address != '')
			$mecard_data .= 'ADR:'.$mecard_address.';';
		if($mecard_tel1 != '')
			$mecard_data .= 'TEL:'.$mecard_tel1.';';
		if($mecard_tel2 != '')
			$mecard_data .= 'TEL:'.$mecard_tel2.';';
		if($mecard_tel3 != '')
			$mecard_data .= 'TEL:'.$mecard_tel3.';';
		if($mecard_tel4 != '')
			$mecard_data .= 'TEL:'.$mecard_tel4.';';
		if($mecard_email != '')
			$mecard_data .= 'EMAIL:'.$mecard_email.';';
		if($mecard_url != '')
			$mecard_data .= 'URL:'.$mecard_url.';';
		
		$data .= urlencode('MECARD:'.$mecard_data.';');
	break;
	
}

$data .= '&amp;size='.$width.'x'.$width;

?>
<div class="qrCode" <?php echo $style; ?> >
	<?php echo $title; ?>
	<img src="<?php echo $data; ?>" alt="Scan this QR Code!" class="img-polaroid" />
</div>