
<?php

// no direct access
defined('_JEXEC') or die;

$mid = $module->id;
$enableName = $params->get('enablename',1);

$apiKey = $params->get('apikey');
$listId = $params->get('listid');
$datacenter = $params->get('datacenter');

$document = JFactory::getDocument();

if($enableName) $document->addStyleDeclaration('
.newsletter-signup input[type="text"] {width:90px;}
@media (min-width: 1200px) { body.res1170 .newsletter-signup input[type="text"] {width:120px;} }');

?>

<div class="newsletter-signup">
	<?php if($params->get('pretext')) echo '<p>'.$params->get('pretext').'</p>'; ?>
	<?php if($apiKey && $listId && $datacenter) { ?>
	<form method="post" id="newsletter_subscribe<?php echo $mid; ?>" name="newsletter_form">
		<?php if($enableName){ ?>
			<input type="text" name="name_nl<?php echo $mid; ?>" id="nl-name" value="" placeholder="<?php echo $params->get('namepl', 'your name'); ?>" />
		<?php } else { ?>
			<input type="hidden" name="name_nl<?php echo $mid; ?>" value="<?php echo $params->get('safename', 'Kallyas User'); ?>"/>
		<?php } ?>
		<input type="text" name="email_nl<?php echo $mid; ?>" id="nl-email" value="" placeholder="<?php echo $params->get('emailpl', 'email@address'); ?>" required="required" />
		<input type="submit" name="submit_nl<?php echo $mid; ?>" id="nl-submit" value="<?php echo $params->get('joinus', 'JOIN US'); ?>" />
	</form>
	<?php } else { ?>
		<p><?php echo JText::_('TPL_KALLYAS_MOD_HGNEWSLETTER_APINOTFOUD');?></p>
	<?php } ?>
	
	<?php
if($apiKey && $listId && $datacenter) {

	if(isset($_POST['submit_nl'.$mid])) {

		$double_optin=false;
		$send_welcome=false;
		$email_type = 'html';
		$email = $_POST['email_nl'.$mid];
		$merge_vars = array( 'YNAME' => $_POST['name_nl'.$mid] );
		
		//replace us5 with your actual datacenter
		$submit_url = "http://".$datacenter.".api.mailchimp.com/1.3/?method=listSubscribe";
		$data = array(
			'email_address'=>$email,
			'apikey'=>$apiKey,
			'id' => $listId,
			'double_optin' => $double_optin,
			'send_welcome' => $send_welcome,
			'merge_vars' => $merge_vars,
			'email_type' => $email_type
		);
		$payload = json_encode($data);
		
		if(function_exists('curl_init')) {
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $submit_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
			 
			$result = curl_exec($ch);
			curl_close ($ch);
			$data = json_decode($result);
			
			if ($data->error){
				echo '<span id="result" style="color:red;">'.JText::_('TPL_KALLYAS_MOD_HGNEWSLETTER_ERROR').'</span>';
			} else {
				echo '<span id="result" style="color:green;">'.JText::_('TPL_KALLYAS_MOD_HGNEWSLETTER_SUBSCRIBED').'</span>';
			}
			
		} else {
			// stop and throw error if cURL not detected
			echo JText::_('TPL_KALLYAS_MOD_HGNEWSLETTER_CURLNOTFOUD');
		}
	} else {
		echo '<span id="result">'.$params->get('notetext').'</span>';
	}
} else {
	// if api key values not found, stop
	echo JText::_('TPL_KALLYAS_MOD_HGNEWSLETTER_APINOTFOUD');
}
?>
	<?php if($params->get('footertext')) echo '<p><small>'.$params->get('footertext').'</small></p>'; ?>
</div><!-- end newsletter-signup -->
