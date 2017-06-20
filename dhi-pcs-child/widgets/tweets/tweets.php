<?php

function eventerra_widget_tweets_init() {
	register_widget( 'eventerra_widget_tweets' );
}
if(class_exists('WP_Http_Curl')) {
	add_action( 'widgets_init', 'eventerra_widget_tweets_init' );
}

/* Widget Class */

class eventerra_widget_tweets extends WP_Widget {

	function __construct() {
	
		parent::__construct(
			'eventerra_widget_tweets',
			'Eventerra: '.esc_html__('Latest Tweets','eventerra'),
			array(
				'classname' => 'eventerra_widget_tweets',
				'description' => esc_html__('A widget that displays your latest tweets.', 'eventerra')
			)
		);
	}
	
	function om_relative_time($time_value)
	{
	  $time_value = strtotime($time_value);
	  $delta = time() - $time_value;
	
	  if ($delta < 60) {
	    return esc_html__('less than a minute ago','eventerra');
	  } elseif($delta < 120) {
	    return esc_html__('about a minute ago','eventerra');
	  } elseif($delta < (60*60)) {
	    return (round($delta / 60)) .' '. esc_html__('minutes ago','eventerra');
	  } elseif($delta < (120*60)) {
	    return esc_html__('about an hour ago','eventerra');
	  } elseif($delta < (24*60*60)) {
	    return esc_html__('about','eventerra'). ' ' . (round($delta / 3600)) .' '. esc_html__('hours ago','eventerra');
	  } elseif($delta < (48*60*60)) {
	    return esc_html__('1 day ago','eventerra');
	  } else {
	    return (round($delta / 86400)) .' '. esc_html__('days ago','eventerra');
	  }
	}

	/* Front-end display of widget. */
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		
		$instance['postcount']=intval($instance['postcount']);
		
		echo wp_kses($before_widget, array(
			'div' => array(
				'id' => array(),
				'class' => array(),
			),
			'span' => array(
				'id' => array(),
				'class' => array(),
			),
		));
	
		if ( $title ) {
			echo wp_kses($before_title . $title . $after_title, array(
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'span' => array(
					'id' => array(),
					'class' => array(),
				),
			));
		}

		require_once("twitteroauth/twitteroauth.php");

		$connection = new TwitterOAuth($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
		$tweets = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$instance['username'].'&count='.$instance['postcount'].($instance['retweets']?'&include_rts=true':'').($instance['replies']?'&exclude_replies=true':''));
		if(empty($tweets->errors)) {
			$statusHTML = array();
		  for ($i=0; $i<count($tweets); $i++){
		    $username = $tweets[$i]->user->screen_name;
		    $status = $tweets[$i]->text;
		    $status=preg_replace('/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;\'">\:\s\<\>\)\]\!])/','<a href="$1" target="_blank">$1</a>',$status);
		    $status=preg_replace('/\B@([_a-z0-9]+)/i','@<a href="http://twitter.com/$1" target="_blank">$1</a>',$status);
		    $statusHTML[]='<li><div class="tweet-status">'.$status.'</div><div class="tweet-time"><a href="'.esc_url('http://twitter.com/'.$username.'/statuses/'.$tweets[$i]->id_str).'" target="_blank">'.$this->om_relative_time($tweets[$i]->created_at).'</a></div></li>';
		  }

			?>
				<ul class="latest-tweets"><?php echo implode('',$statusHTML) ?></ul>
				<?php if($instance['follow_text']) { ?>
				<p class="twitter-follow">
					<a href="<?php echo esc_url('http://twitter.com/'. $instance['username']); ?>" target="_blank" class="omicon-twitter"><span><?php echo esc_html($instance['follow_text']); ?></span></a>
				</p>
				<?php } ?>
			<?php
		} else {
			echo '<p>'.esc_html__('An error has occured.','eventerra').'</p>';
		}
		echo wp_kses($after_widget, array(
			'div' => array(
				'id' => array(),
				'class' => array(),
			),
			'span' => array(
				'id' => array(),
				'class' => array(),
			),
		));
	}

	/* Sanitize widget form values as they are saved. */

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['postcount'] = strip_tags( $new_instance['postcount'] );
		$instance['follow_text'] = strip_tags( $new_instance['follow_text'] );
		$instance['retweets'] = strip_tags( $new_instance['retweets'] );
		$instance['replies'] = strip_tags( $new_instance['replies'] );
		
		$instance['consumerkey'] =  $new_instance['consumerkey'] ;
		$instance['consumersecret'] =  $new_instance['consumersecret'] ;
		$instance['accesstoken'] =  $new_instance['accesstoken'] ;
		$instance['accesstokensecret'] =  $new_instance['accesstokensecret'] ;

		return $instance;
	}
	
	/* Back-end widget form. */
	
	function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'title' => 'Latest Tweets',
			'username' => 'olevmedia',
			'postcount' => '2',
			'follow_text' => 'Follow @olevmedia',
			'retweets' => false,
			'replies' => false,
			'consumerkey' => '',
			'consumersecret' => '',
			'accesstoken' => '',
			'accesstokensecret' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e('Twitter username e.g. mopc007', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>
		
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'postcount' ) ); ?>"><?php esc_html_e('Number of tweets', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'postcount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postcount' ) ); ?>" value="<?php echo esc_attr( $instance['postcount'] ); ?>" />
		</p>
		
		<!-- Retweets: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'retweets' ) ); ?>"><?php esc_html_e('Include retweets', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'retweets' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'retweets' ) ); ?>" value="true" <?php if( $instance['retweets'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Replies: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'replies' ) ); ?>"><?php esc_html_e('Exclude replies', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'replies' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'replies' ) ); ?>" value="true" <?php if( $instance['replies'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Follow Text: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'follow_text' ) ); ?>"><?php esc_html_e('Follow Text e.g. Follow @mopc007', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'follow_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'follow_text' ) ); ?>" value="<?php echo esc_attr( $instance['follow_text'] ); ?>" />
		</p>

		<!--  -->
		<p>
			<b>You need to create an Application at <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> and fill the fields below:</b>
		</p>
		
		<!-- Consumer key: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'consumerkey' ) ); ?>"><?php esc_html_e('OAuth Consumer key', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumerkey' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumerkey' ) ); ?>" value="<?php echo esc_attr( $instance['consumerkey'] ); ?>" />
		</p>		

		<!-- Consumer secret: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'consumersecret' ) ); ?>"><?php esc_html_e('OAuth Consumer secret', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumersecret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumersecret' ) ); ?>" value="<?php echo esc_attr( $instance['consumersecret'] ); ?>" />
		</p>		

		<!-- Access token: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'accesstoken' ) ); ?>"><?php esc_html_e('Access token', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'accesstoken' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'accesstoken' ) ); ?>" value="<?php echo esc_attr( $instance['accesstoken'] ); ?>" />
		</p>		

		<!-- Access token secret: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'accesstokensecret' ) ); ?>"><?php esc_html_e('Access token secret', 'eventerra') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'accesstokensecret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'accesstokensecret' ) ); ?>" value="<?php echo esc_attr( $instance['accesstokensecret'] ); ?>" />
		</p>		

		
	<?php
	}
}

?>