<?php  
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2013 hogash.com. All rights reserved.
# @license  Commercial License http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;
// developer mode? This is added only for development purpose, in case you want to work on this site you will make lots of refresh's and requests and therefore it's better to disable the twitter script and sharing buttons
$dev_mode = $templateparams->get('dev_mode',0);

$twitter_follow = $templateparams->get('twitter_follow');
$tweet_button = $templateparams->get('twitter_bt_enable');
$twitter_id = $templateparams->get('twitter_id');


?>

<div id="bottom" class="container">
	
	<?php if(!$dev_mode): ?>
	<div class="row">
	
		<?php if($twitter_id): ?>
		<div class="span6">
			<div class="twitter-feed">
			 
				<!-- twitter feeds -->
				<div class="tweets" id="twitterFeed"><small>Please wait whilst our latest tweets load</small></div>
				
				<script type="text/javascript">
				jQuery(window).load(function(){
					jQuery.getScript(
						'http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js'
						, function() {
							//TWITTER SET UP
							if (typeof getTwitters == 'function') {
							  getTwitters('twitterFeed', { 
								  id: '<?php echo $twitter_id; ?>', //ADD IN YOUR OWN TWITTER ID HERE
								  count: 1, 
								  enableLinks: true, 
								  ignoreReplies: true, 
								  clearContents: true,
								  template: '<a href="http://twitter.com/%user_screen_name%/statuses/%id_str%/" class="twTime"><span>%time%</span></a> "%text%"',
								  timeout: 1,
								  onTimeout: function () {
									  this.innerHTML = 'There seems to be a problem with loading the tweets. Please refresh or try again later.';
								  }
							  });
							}
						}
					);
				});
				</script>

				<?php if($twitter_follow): ?>
				<a href="https://twitter.com/<?php echo $twitter_id; ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $twitter_id; ?></a>
				<?php endif; ?>

			</div><!-- end twitter-feed -->
		</div>
		<?php endif; ?>
		
		<div class="span6">
		<?php if ($templateparams->get('fblike_url') or $templateparams->get('twitter_bt_enable') or $templateparams->get('gplus_enable') or $templateparams->get('pin_bt_enable') ): ?>
			<ul class="social-share fixclear">
			
			<?php if ($templateparams->get('fblike_url')): ?>
				<li class="sc-facebook">
					<div class="fb-like" data-href="<?php echo $templateparams->get('fblike_url'); ?>" data-send="false" data-layout="button_count" data-width="120" data-show-faces="false" data-font="lucida grande"></div>
				</li><!-- facebook like -->
			<?php endif; ?>
			
			<?php if ($tweet_button): ?>
				<li class="sc-twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $templateparams->get('twitter_text'); ?>" data-via="<?php echo $templateparams->get('twitter_via'); ?>" data-hashtags="<?php echo $templateparams->get('twitter_hashtag'); ?>">Tweet</a>
				</li><!-- tweet button -->
			<?php endif; ?>
			
			<?php if ($templateparams->get('gplus_enable')): ?>
				<li class="sc-gplus">
					<script type="text/javascript">
					(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					})();
					</script>
					<div class="g-plusone" data-size="medium"></div>
				</li><!-- Gogle Plus Button -->
			<?php endif; ?>
			
			<?php if ($templateparams->get('pin_bt_enable')):?>
				<li class="sc-pinterest">
					<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($templateparams->get('pinterest_url')); ?>&amp;media=<?php echo urlencode($templateparams->get('pinterest_image')); ?>&amp;description=<?php echo urlencode($templateparams->get('pinterest_desc')); ?>" class="pin-it-button" count-layout="horizontal"><img src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" alt="Pin It" /></a>
					<script type="text/javascript">(function(e,t,n){var r,i=t.getElementsByTagName("SCRIPT")[0],s=n.length,o=0,u=function(){for(o=0;o<s;o=o+1){r=t.createElement("SCRIPT");r.type="text/javascript";r.async=true;r.src=n[o];i.parentNode.insertBefore(r,i)}};if(e.attachEvent){e.attachEvent("onload",u)}else{e.addEventListener("load",u,false)}})(window,document,["//assets.pinterest.com/js/pinit.js"]);</script>
				</li><!-- Pin IT Button -->
			<?php endif; ?>
			</ul>
		<?php endif; ?>
			
			<?php if($tweet_button or $twitter_follow): ?>
			<script type="text/javascript">// <![CDATA[
			(function() {
					var twitterScriptTag = document.createElement('script');
					twitterScriptTag.type = 'text/javascript';
					twitterScriptTag.async = true;
					twitterScriptTag.src = 'http://platform.twitter.com/widgets.js';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(twitterScriptTag, s);
			})();
			// ]]>
			//!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="http://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			</script><!-- twitter script -->
			<?php endif; ?>
		</div>
	</div><!-- end row -->
	<?php endif; // devmode ?>
	
	<div class="row">
		<div class="span12">
			<div class="bottom fixclear">
				<?php echo TplHelper::socialIcons($templateparams); ?>
				
				<div class="copyright">
				<?php
				if($templateparams->get('copyright_logo'))
					echo '<a href="'.$this->baseurl.'"><img src="'.$templateparams->get('copyright_logo').'" alt="'.$templateparams->get('logo_alt').'" /></a>';
				echo $templateparams->get('copyright_text');
				?>
				</div><!-- end copyright -->
				
			</div><!-- end bottom -->
		</div>
	</div><!-- end row -->
</div>