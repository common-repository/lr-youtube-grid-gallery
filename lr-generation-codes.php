<?php 
function lryg_extract_youtube_video_id($url){
		$vid_id = "";
		$flag = false;
		if(isset($url) && !empty($url)){
			$parts = explode("?", $url);
			if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){
				$params = explode("&", $parts[1]);
				if(isset($params) && !empty($params) && is_array($params)){
					foreach($params as $param){
						$kv = explode("=", $param);
						if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){
							if($kv[0]=='v'){
								$vid_id = $kv[1];
								$flag = true;
								break;
							}
						}
					}
				}
			}
			if(!$flag){
				$needle = "youtu.be/";
				$pos = null;
				$pos = strpos($url, $needle);
				if ($pos !== false) {
					$start = $pos + strlen($needle);
					$vid_id = substr($url, $start, 11);
					$flag = true;
				}
			}
		}
		return $vid_id;
	}	
	function lryg_youtubeembedfromUrl($youtube_url){
		$vid_id = lryg_extract_youtube_video_id($youtube_url);
		return lryg_generateyoutubeembedcode($vid_id);
	}
	function lryg_generateyoutubeembedcode($vid_id){
		$html = $vid_id;
		return $html;
	}