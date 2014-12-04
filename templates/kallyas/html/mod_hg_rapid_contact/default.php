<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Email Parameters
$recipient = $params->get('email_recipient', '');
$fromName = @$params->get('from_name', 'Rapid Contact');
$fromEmail = @$params->get('from_email', 'rapid_contact@yoursite.com');

// Text Parameters
$myEmailLabel = $params->get('email_label', 'Email:');
$myNameLabel = $params->get('name_label', 'Name:');
$mySubjectLabel = $params->get('subject_label', 'Subject:');
$myMessageLabel = $params->get('message_label', 'Message:');
$buttonText = $params->get('button_text', 'Send Message');
$pageText = $params->get('page_text', 'Thank you for your contact.');
$errorText = $params->get('error_text', 'Your message could not be sent. Please try again.');
$noEmail = $params->get('no_email', 'Please write your email');
$invalidEmail = $params->get('invalid_email', 'Please write a valid email');
$wrongantispamanswer = $params->get('wrong_antispam', 'Wrong anti-spam answer');
$pre_text = $params->get('pre_text', '');

// Size and Color Parameters
$thanksTextColor = $params->get('thank_text_color', '#FF0000');
$error_text_color = $params->get('error_text_color', '#FF0000');
$emailWidth = $params->get('email_width', '15');
$subjectWidth = $params->get('subject_width', '15');
$messageWidth = $params->get('message_width', '13');
$buttonWidth = $params->get('button_width', '100');
$label_pos = $params->get('label_pos', '0');
$addcss = $params->get('addcss', 'div.rapid_contact tr, div.rapid_contact td { border: none; padding: 3px; }');

// URL Parameters
$exact_url = $params->get('exact_url', true);
$disable_https = $params->get('disable_https', true);
$fixed_url = $params->get('fixed_url', true);
$myFixedURL = $params->get('fixed_url_address', '');

// Anti-spam Parameters
$enable_anti_spam = $params->get('enable_anti_spam', true);
$myAntiSpamQuestion = $params->get('anti_spam_q', 'How many eyes has a typical person?');
$myAntiSpamAnswer = $params->get('anti_spam_a', '2');
$anti_spam_position = $params->get('anti_spam_position', 0);

// Module Class Suffix Parameter
$mod_class_suffix = $params->get('moduleclass_sfx', '');


if ($fixed_url) {
  $url = $myFixedURL;
}
else {
  if (!$exact_url) {
    $url = JURI::current();
  }
  else {
    if (!$disable_https) {
      $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }
    else {
      $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }
  }
}

$url = htmlentities($url, ENT_COMPAT, "UTF-8");

$myError = '';
$CORRECT_ANTISPAM_ANSWER = '';
$CORRECT_EMAIL = '';
$CORRECT_SUBJECT = '';
$CORRECT_MESSAGE = '';

if (isset($_POST["rp_email"])) {
	$CORRECT_SUBJECT = htmlentities($_POST["rp_subject"], ENT_COMPAT, "UTF-8");
	$CORRECT_MESSAGE = htmlentities($_POST["rp_message"], ENT_COMPAT, "UTF-8");
	$CORRECT_NAME = htmlentities($_POST["rp_name"], ENT_COMPAT, "UTF-8");
	
	// check anti-spam
	if ($enable_anti_spam) {
		if ($_POST["rp_anti_spam_answer"] != $myAntiSpamAnswer) {
			$myError = $wrongantispamanswer;
			modRapidContactHelper::doError($wrongantispamanswer, 'warning');
		} else {
			$CORRECT_ANTISPAM_ANSWER = htmlentities($_POST["rp_anti_spam_answer"], ENT_COMPAT, "UTF-8");
		}
	}
	// check email
	if ($_POST["rp_email"] === "") {
		$myError = $noEmail;
		modRapidContactHelper::doError($noEmail, 'warning');
	}
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower($_POST["rp_email"]))) {
		$myError = $invalidEmail;
		modRapidContactHelper::doError($invalidEmail, 'warning');
	} else {
		$CORRECT_EMAIL = htmlentities($_POST["rp_email"], ENT_COMPAT, "UTF-8");
	}

	if ($myError == '') {
		$mySubject = $_POST["rp_subject"];
		$myMessage = 'You received a message from  '. $_POST["rp_name"] .'( '. $_POST["rp_email"].' )'."\n\n". $_POST["rp_message"];
	
		$mailSender = &JFactory::getMailer();
		$mailSender->addRecipient($recipient);
	
		$mailSender->setSender(array($fromEmail,$fromName));
		$mailSender->addReplyTo(array( $_POST["rp_email"], '' ));
	
		$mailSender->setSubject($mySubject);
		$mailSender->setBody($myMessage);
	
		if ($mailSender->Send() !== true) {
			modRapidContactHelper::doError($errorText, 'error');
			return true;
		} else {
			modRapidContactHelper::doError($pageText, 'message');
			return true;
		}
	}
} // end if posted

// check recipient
if ($recipient === "") {
	modRapidContactHelper::doError('No recipient specified', 'warning');
	return true;
}

print '
<div id="contact_form" class="rapid_contact ' . $mod_class_suffix . '">
	<form action="' . $url . '" method="post" class="form-horizontal">' . "\n" .
      '<div class="intro_text ' . $mod_class_suffix . '">'.$pre_text.'</div>' . "\n";

if ($myError != '') {
	//print $myError;
}

// print email input
print '
<div class="control-group">
	<label class="control-label" for="rp_name">'.$myNameLabel.'</label>
	<div class="controls">
		<input class=" inputbox input-xlarge" type="text" placeholder="'.$myNameLabel.'" name="rp_name" id="rp_name" value="'.$CORRECT_NAME.'" />
	</div>
</div><!-- end control group -->' . "\n";
// print email input
print '
<div class="control-group">
	<label class="control-label" for="rp_email">'.$myEmailLabel.'</label>
	<div class="controls">
		<input class=" inputbox input-xlarge" type="text" placeholder="'.$myEmailLabel.'" name="rp_email" id="rp_email" value="'.$CORRECT_EMAIL.'" required="required" />
	</div>
</div><!-- end control group -->' . "\n";
// print subject input
print '
<div class="control-group">
	<label class="control-label" for="rp_subject">'.$mySubjectLabel.'</label>
	<div class="controls">
		<input class=" inputbox input-xlarge" type="text" placeholder="'.$mySubjectLabel.'" name="rp_subject" id="rp_subject" value="'.$CORRECT_SUBJECT.'" />
	</div>
</div><!-- end control group -->' . "\n";

// print message input
print '
<div class="control-group">
	<label class="control-label" for="rp_message">'.$myMessageLabel.'</label>
	<div class="controls">
		<textarea class="textarea span4" placeholder="'.$myMessageLabel.'" name="rp_message" id="rp_message" required="required">'.$CORRECT_MESSAGE.'</textarea>
	</div>
</div><!-- end control group -->' . "\n";

//print anti-spam
if ($enable_anti_spam) {
	if ($anti_spam_position == 1) {
print '
<div class="control-group">
	<div class="controls">
		<label for="rp_anti_spam_answer">'.$myAntiSpamQuestion.'</label>
		<input class=" inputbox input-mini" type="text" name="rp_anti_spam_answer" id="rp_anti_spam_answer" value="'.$CORRECT_ANTISPAM_ANSWER.'" />
	</div>
</div><!-- end control group -->' . "\n";
	}
}
// print button
print '
<div class="control-group">
	<div class="controls">
		<input class=" btn " id="submit-form" type="submit" name="submit" value="'.$buttonText.'" />
	</div>
</div><!-- end control group -->

</form></div>' . "\n";
return true;
