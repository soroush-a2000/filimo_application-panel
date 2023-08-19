<?php 

$seasons_list =  array();

foreach ($seasons as $key => $season) {
	$season_obj = null;
	$season_obj["id"]=$season->getId();
	$season_obj["title"]=$season->getTitle();
	$episodes_list =  array();
	foreach ($season->getEpisodes() as $episode) {
		$episode_obj = null;
		if ($episode->getEnabled()) {
			
			$episode_obj["id"] = $episode->getId();
			$episode_obj["title"] = $episode->getTitle();
			$episode_obj["description"] = $episode->getDescription();
			$episode_obj["duration"] = $episode->getDuration();
			$episode_obj["downloadas"] = $episode->getDownloadas();
			$episode_obj["playas"] = $episode->getPlayas();
			if($episode->getMedia())
				$episode_obj["image"] = $this['imagine']->filter($view['assets']->getUrl($episode->getMedia()->getLink()), 'episode_thumb');

			$source_episode_list =  array();
			foreach ($episode->getSources() as $key => $source_episode) {
				$source_episode_obj = array();
				$source_episode_obj["id"]=$source_episode->getId();
                $source_episode_obj["quality"]=$source_episode->getQuality();
				if ($source_episode->getType()=="file") {
					$source_episode_obj["url"]=$app->getRequest()->getScheme()."://".$app->getRequest()->getHttpHost()."/". $source_episode->getMedia()->getLink();
					$source_episode_obj["type"]=$source_episode->getMedia()->getExtension();

				}else{
					$source_episode_obj["type"]=$source_episode->getType();
					$source_episode_obj["url"]=$source_episode->getUrl();
				}
				$source_episode_list[] = $source_episode_obj;
			}
			$episode_obj["sources"] = $source_episode_list;

			$episodes_list[]=$episode_obj;
		}
	}
	$season_obj["episodes"] = $episodes_list;
	$seasons_list[]=$season_obj;
}


echo json_encode($seasons_list, JSON_UNESCAPED_UNICODE);
?>