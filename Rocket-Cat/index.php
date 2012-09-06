<?php
	if(file_exists('install.php')){
		header('Location: install.php');
		exit();
	}
	
	include 'config.php';
	error_reporting(0);
	
	if(time() - fileatime('ca.che') > $config['max_age']){
		$api = curl_init();
		curl_setopt($api, CURLOPT_URL, 'https://www.googleapis.com/plus/v1/people/' . $config['gplus_id'] . '/activities/public?key=' . $config['api_key'] . '&maxResults=' . $config['max_post']);
		curl_setopt($api, CURLOPT_TIMEOUT, 3);
		curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
		
		$posts_raw = curl_exec($api);
		
		if($posts_raw === false) $result = file_get_contents('ca.che');
		else{
			$posts_decoded = json_decode($posts_raw);	
			$items = $posts_decoded->items;
			$result = '';
			
			foreach($items as $item){
				if(isset($item->object->attachments[0]) && $item->object->attachments[0]->objectType == 'article'){
					$title = $item->object->attachments[0]->displayName;
					$url = $item->object->attachments[0]->url;
				}
				elseif(isset($item->object->attachments[0]) && $item->object->attachments[0]->objectType == 'photo'){
					if(isset($item->object->attachments[0]->displayName)) $title = $item->object->attachments[0]->displayName;
					else $title = 'Image';
					$url = $item->object->attachments[0]->fullImage->url;
				}
				elseif(isset($item->object->attachments[0]) && $item->object->attachments[0]->objectType == 'video'){
					if(isset($item->object->attachments[0]->displayName)) $title = $item->object->attachments[0]->displayName;
					else $title = 'Vidéo';
					$url = $item->object->attachments[0]->url;
				}
				else{
					$title = 'Note';
					$url = $item->object->url;
				}
				$content = $item->object->content;
				$date = date('r', strtotime($item->published));
				
				$result .= '<item><title><![CDATA[' . $title . ']]></title><link><![CDATA[' . $url . ']]></link><guid isPermaLink="true"><![CDATA[' . $url . ']]></guid><description><![CDATA[' . $content . ']]></description><pubDate>' . $date . '</pubDate></item>';
			}
		}
		
		file_put_contents('ca.che', $result);
	}
	else $result = file_get_contents('ca.che');
	
	header('Content-Type: application/rss+xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?><rss version="2.0"><channel><title>' . $config['title'] . '</title><description>' . $config['description'] . '</description><link>https://plus.google.com/' . $config['gplus_id'] . '/posts</link>' . $result . '</channel></rss>';
?>