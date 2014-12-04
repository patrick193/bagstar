<?php
/**
 * JLcomments pro
 *
 * @version 2.4
 * @author Zhukov Artem (artem@joomline.ru)
 * @copyright (C) 2012 by Zhukov Artem(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
 
// no direct access
defined('_JEXEC') or die;

class plgJLCommentsProHelperK2
{
	static function get_comments_form($item){
		$user = JFactory::getUser();
		if (!$user->guest && $user->id == $item->created_by && $item->params->get('inlineCommentsModeration')){
			$inlineCommentsModeration = true;$commentsPublished = false;
		} else {
			$inlineCommentsModeration = false;$commentsPublished = true;
		}
		$html = '<div class="itemComments">';
		
		if($item->params->get('commentsFormPosition')=='above' && $item->params->get('itemComments') && !JRequest::getInt('print') && ($item->params->get('comments') == '1' || ($item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($item->catid)))){
			$html .= '<div class="itemCommentsForm">';
			$html .= plgJLCommentsProHelperK2::get_form($item);
			$html .= '</div>';
		}
		//echo '<pre>2'.print_r($item->numOfComments,true).'</pre>';
		
		if($item->numOfComments>0 && $item->params->get('itemComments') && ($item->params->get('comments') == '1' || ($item->params->get('comments') == '2'))){
		$html .= '<h3 class="itemCommentsCounter"><span>';
		$html .= $item->numOfComments.'</span> ';
		$html .= ($item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT') ;
		$html .= '</h3>';
		
		
		$comments_list = plgJLCommentsProHelperK2::get_list_comments($item);
		
		
		$html .= '<ul class="itemCommentsList">';
	    foreach ($comments_list as $key=>$comment){
			
			$class1 = ($key%2) ? "odd" : "even"; 
			$class2 = (!$item->created_by_alias && $comment->userID==$item->created_by) ? " authorResponse" : ""; 
			$class3 = ($comment->published) ? '':' unpublishedComment';
			
			$html .= '<li class="'. $class1 . $class2 . $class3 .'">';

	    	$html .= '<span class="commentLink">';
		    $html .= '<a href="'. $item->link .'#comment'.$comment->id.'" name="comment'. $comment->id .'" id="comment'. $comment->id .'">'. JText::_('K2_COMMENT_LINK') .'</a></span>';

			if($comment->userImage){
				$html .= '<img src="'. $comment->userImage .'" alt="'. JFilterOutput::cleanText($comment->userName) .'" width="'. $item->params->get('commenterImgWidth') .'" />';
			}

			$html .= '<span class="commentDate">';
		    $html .= JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2'));
		    $html .= '</span>';

		    $html .= '<span class="commentAuthorName">';
			$html .= JText::_('K2_POSTED_BY');
			
			if(!empty($comment->userLink)){
			   $html .= '<a href="'. JFilterOutput::cleanText($comment->userLink) .'" title="'. JFilterOutput::cleanText($comment->userName) .'" target="_blank" rel="nofollow">'. $comment->userName .'</a>';
			} else {
			    $html .= $comment->userName;
			}
		    $html .= '</span>';

		    $html .= '<p>'. $comment->commentText .'</p>';

			if($inlineCommentsModeration || ($comment->published && ($item->params->get('commentsReporting')=='1' || ($item->params->get('commentsReporting')=='2' && !$user->guest)))){
				$html .= '<span class="commentToolbar">';
				if($inlineCommentsModeration){
					if(!$comment->published){
						$html .= '<a class="commentApproveLink" href="'. JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw') .'">'. JText::_('K2_APPROVE') .'</a>';
					}

					$html .= '<a class="commentRemoveLink" href="'. JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw') .'">'. JText::_('K2_REMOVE') .'</a>';
				}

				if($comment->published && ($item->params->get('commentsReporting')=='1' || ($item->params->get('commentsReporting')=='2' && !$user->guest))){
					$html .= '<a class="modal" rel="{handler:\'iframe\',size:{x:560,y:480}}" href="'. JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id ) .'">'. JText::_('K2_REPORT') .'</a>';
				}

				if($comment->reportUserLink){
					$html .= '<a class="k2ReportUserButton" href="'. $comment->reportUserLink .'">'. JText::_('K2_FLAG_AS_SPAMMER') .'</a>';
				}

				$html .= '</span>';
			}

			$html .= '<div class="clr"></div>';
			$html .= '</li>';
		}
		$html .= '</ul>';
		
		
		
		} // end of list comments
		
		
		
		
		
		
		if($item->params->get('commentsFormPosition')=='below' && $item->params->get('itemComments') && !JRequest::getInt('print') && ($item->params->get('comments') == '1' || ($item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($item->catid)))){
			$html .= '<div class="itemCommentsForm">';
			$html .= plgJLCommentsProHelperK2::get_form($item);
			$html .= '</div>';
		}
		
		$k2postcom = JText::_('K2_LOGIN_TO_POST_COMMENTS');
		$user = JFactory::getUser(); if ($item->params->get('comments') == '2' && $user->guest){
				$html .= '<div>'. $k2postcom .'</div>';
			}
		
		
		$html .= '</div>';
	
		return $html;
	
	}
	
	
	


	
	static function get_form($item){
	
		$form = '<h3>'. JText::_('K2_LEAVE_A_COMMENT') .'</h3>';

		if($item->params->get('commentsFormNotes')){
			$form .= '<p class="itemCommentsFormNotes">';
			if($item->params->get('commentsFormNotesText')){
				$form .= nl2br($item->params->get('commentsFormNotesText'));
			} else{
				$form .= JText::_('K2_COMMENT_FORM_NOTES');
			}
			$form .= '</p>';
		}
		
		$path = JURI::root(true);
		$k2mes = JText::_('K2_MESSAGE');
		$k2here = JText::_('K2_ENTER_YOUR_MESSAGE_HERE');
		$k2name = JText::_('K2_NAME');
		$k2youname = JText::_('K2_ENTER_YOUR_NAME');
		$k2mail = JText::_('K2_EMAIL');
		$k2entermail = JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS');
		$k2url = JText::_('K2_WEBSITE_URL');
		$k2enterurl = JText::_('K2_ENTER_YOUR_SITE_URL');
		$k2submit = JText::_('K2_SUBMIT_COMMENT');
		$k2getid =  JRequest::getInt('id');
		$k2token = JHTML::_('form.token');
		
		$form .= <<<HTML
		<form action="$path/index.php" method="post" id="comment-form" class="form-validate">
		<label class="formComment" for="commentText">$k2mes *</label>
		<textarea rows="20" cols="10" class="inputbox" onblur="if(this.value=='') this.value='$k2here';" onfocus="$k2here') this.value='';" name="commentText" id="commentText">$k2here</textarea>

		<label class="formName" for="userName">$k2name *</label>
		<input class="inputbox" type="text" name="userName" id="userName" value="$k2youname" onblur="if(this.value=='') this.value='$k2youname';" onfocus="if(this.value=='$k2youname') this.value='';" />

		<label class="formEmail" for="commentEmail">$k2mail *</label>
		<input class="inputbox" type="text" name="commentEmail" id="commentEmail" value="$k2entermail" onblur="if(this.value=='') this.value='$k2entermail';" onfocus="if(this.value=='$k2entermail') this.value='';" />

		<label class="formUrl" for="commentURL">$k2url</label>
		<input class="inputbox" type="text" name="commentURL" id="commentURL" value="$k2enterurl"  onblur="if(this.value=='') this.value='$k2enterurl';" onfocus="if(this.value=='$k2enterurl') this.value='';" />

		<input type="submit" class="button" id="submitCommentButton" value="$k2submit" />

		<span id="formLog"></span>

		<input type="hidden" name="option" value="com_k2" />
		<input type="hidden" name="view" value="item" />
		<input type="hidden" name="task" value="comment" />
		<input type="hidden" name="itemID" value="$k2getid" />
		$k2token
	</form>
HTML;


		
			
		return $form;
	}
	
	
static function get_list_comments($item){
	$user = JFactory::getUser();
	
	$reportSpammerFlag = false;
	if (K2_JVERSION != '15'){
		if ($user->authorise('core.admin', 'com_k2')){
			$reportSpammerFlag = true;$document = JFactory::getDocument();
			$document->addScriptDeclaration('var K2Language = ["'.JText::_('K2_REPORT_USER_WARNING', true).'"];');
		}
	} else {
		if ($user->gid > 24){
			$reportSpammerFlag = true;
		}
	}	
				
	$limit = $item->params->get('commentsLimit');	
	$limitstart = JRequest::getInt('limitstart', 0);

	$comments = plgJLCommentsProHelperK2::getItemComments($item->id, $limitstart, $limit, $commentsPublished,$item);
	
	$pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";

	for ($i = 0; $i < sizeof($comments); $i++){
		$comments[$i]->commentText = nl2br($comments[$i]->commentText);
		$comments[$i]->commentText = preg_replace($pattern, '<a target="_blank" rel="nofollow" href="\0">\0</a>', $comments[$i]->commentText);
		$comments[$i]->userImage = K2HelperUtilities::getAvatar($comments[$i]->userID, $comments[$i]->commentEmail, $item->params->get('commenterImgWidth'));
		if ($comments[$i]->userID > 0){
			$comments[$i]->userLink = K2HelperRoute::getUserRoute($comments[$i]->userID);
		} else {
			$comments[$i]->userLink = $comments[$i]->commentURL;
		}
		if ($reportSpammerFlag && $comments[$i]->userID > 0){
			$comments[$i]->reportUserLink = JRoute::_('index.php?option=com_k2&view=comments&task=reportSpammer&id='.$comments[$i]->userID.'&format=raw');
		} else {
			$comments[$i]->reportUserLink = false;
		}
	}
	//echo "DDDD<pre>".print_r($comments,true)."</pre>";
	return $comments;			
		
		
}


function getItemComments($itemID, $limitstart, $limit, $published = true,$item)
	{
		$order = $item->params->get('commentsOrdering', 'DESC');
		$ordering = ($order == 'DESC') ? 'DESC' : 'ASC';
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__k2_comments WHERE itemID=".(int)$itemID;
		if ($published)
		{
			$query .= " AND published=1 ";
		}
		$query .= " ORDER BY commentDate {$ordering}";
		$db->setQuery($query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		
		return $rows;
	}
	
	
	
}