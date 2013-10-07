<?php 

class Twitter_Feed extends WP_Widget {
	
	function Twitter_Feed() {
		$widget_opts = array( 'description' => __('Use this widget is to show the tweets of a specific user.') );
		parent::WP_Widget(false, 'Twitter Feed', $widget_opts);
	}
	function form($instance) {
		
		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';  
        echo '<p><label>';
		echo _e('Title:').'<input class="widefat" name="'. $this->get_field_name('title').'" type="text" value="'. $title.'" />';
        echo '</label></p>';
		

		$username = (isset($instance['username'])) ? esc_attr($instance['username']) : '';  
        echo '<p><label>';
		echo _e('Username:').'<input class="widefat" name="'. $this->get_field_name('username').'" type="text" value="'. $username.'" />';
        echo '</label></p>';
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		require_once('oauth/twitteroauth.php');
		$args['title'] = $instance['title'];
		
		$args['username'] = (isset($instance['username'])) ? $instance['username'] : 'BritishTeddies';
		echo $args['before_widget'] . $args['before_title'] . '<a href="http://twitter.com/'.$args['username'].'" target="_blank" style="color: inherit;">' . $args['title'] . '</a>'. $args['after_title'];
		$key = 'PsYqPIz78oVFNAieHZn1pg';
		$secret = 't08PgTwn9JLPhBt3TbGZZakTCavJDq5wK6cb9eU';
		$token = '1361869022-Smh5Dmu0auCoaol9Bhy5CcFMWd5x6vbVFMH8paL';
		$token_secret = 'zoZIhrRztmS6jRqWVQ8DTC7brfhfhvobbGyQUhSI';
		$connection = new TwitterOAuth($key, $secret, $token, $token_secret);
		$tweets = $connection->get('statuses/user_timeline', array('screen_name' => 'BritishTeddies', 'count' => 20,'trim_user' => false, 'exclude_replies' => false, 'include_rts' => true));
		if(isset($tweets)):

		?>
	    <ul id="twitter-feed">
	        
			<?php foreach($tweets as $tweet): ?>	
			<?php $user = $tweet['user']; ?>
			<li class="tweet clearfix">
					<div class="span two">
						<a href="http://twitter.com/<?php echo $user['screen_name']; ?>" target="_blank" class="tweet-authorphoto">
							<img src="<?php echo $user['profile_image_url']; ?>" class="scale">
						</a>
					</div>
					<div class="tweet-content span eight">
						<header class="tweet-header" >
							<a  href="http://twitter.com/<?php echo $user['screen_name']; ?>" target="_blank" class="yanone-kaffeesatz-bold big user-title uppercase"><?php echo $user['name'] ?></a>
							&nbsp;&nbsp;<a class="open-sans user-name tiny" href="http://twitter.com/<?php echo $user['screen_name']; ?>" target="_blank" >@<?php echo $user['screen_name'] ?></a>
						</header>
						<div class="tweet-text open-sans"><p class="tiny"><?php echo $tweet['text']; ?></p></div>
						<div class="tweet-meta">
							<span class="tweet-time tiny grey arial"><i aria-hidden="true" class="icon-twitter blue"></i>  <?php echo $this->relativeTime($tweet['created_at']); ?></span><br />
						</div>
					</div>
				</li>
			<?php endforeach; ?>
        </ul>
		<?php endif;?>
        <script>
        	
			function relative_time(timeValue) {
				var values = timeValue.split(' ');
				timeValue = values[1] + ' ' + values[2] + ', ' + values[5] + ' ' + values[3];
				var parsedDate = Date.parse(timeValue);
				var relativeTo = (arguments.length > 1) ? arguments[1] : new Date();
				var delta = parseInt((relativeTo.getTime() - parsedDate) / 1000);
				delta = delta + (relativeTo.getTimezoneOffset() * 60);

				var r = '';
				if (delta < 60) {
					r = 'a minute ago';
				} else if(delta < 120) {
					r = 'couple of minutes ago';
				} else if(delta < (45*60)) {
					r = (parseInt(delta / 60)).toString() + ' minutes ago';
				} else if(delta < (90*60)) {
					r = 'an hour ago';
				} else if(delta < (24*60*60)) {
					r = '' + (parseInt(delta / 3600)).toString() + ' hours ago';
				} else if(delta < (48*60*60)) {
					r = '1 day ago';
				} else {
					r = (parseInt(delta / 86400)).toString() + ' days ago';
				}

				return r;
			}
        </script>
 
        <footer class="widget-footer twitter-footer">
           	<p class="social-links">
           		<?php if(get_gbteddybear_option('facebook_url')): ?>
           		<a href="<?php echo get_gbteddybear_option('facebook_url'); ?>" class="facebook-btn" target="_blank"></a>
	           	<?php endif; ?>
	       		<?php if(get_gbteddybear_option('facebook_url')): ?>
    			<a href="<?php echo get_gbteddybear_option('twitter_url'); ?>" class="twitter-btn" target="_blank"></a>
				<?php endif; ?>
	       		<?php if(get_gbteddybear_option('pinterest_url')): ?>
    			<a href="<?php echo get_gbteddybear_option('pinterest_url'); ?>" class="pinterest-btn" target="_blank"></a>
				<?php endif; ?>
	       		<?php if(get_gbteddybear_option('google_plus_url')): ?>
    			<a href="<?php echo get_gbteddybear_option('google_plus_url'); ?>" class="google-plus-btn" target="_blank"></a>
				<?php endif; ?>
			</p>
        </footer>
		<?php echo $args['after_widget'];
	}

	function relativeTime($date) {
	    $diff = time() - strtotime($date);
		if ($diff<60)
			return $diff . " second" . $this->plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<60)
			return $diff . " minute" . $this->plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<24)
			return $diff . " hour" . $this->plural($diff) . " ago";
		$diff = round($diff/24);
		if ($diff<7)
			return $diff . " day" . $this->plural($diff) . " ago";
		$diff = round($diff/7);
		if ($diff<4)
			return $diff . " week" . $this->plural($diff) . " ago";
		return "on " . date("F j, Y", strtotime($date));
	}

	function plural($num) {
		if ($num != 1)
			return "s";
	}
}

register_widget('Twitter_Feed');



?>
