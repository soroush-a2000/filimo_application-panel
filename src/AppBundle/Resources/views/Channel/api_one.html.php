<?php

$ch["id"] = $channel->getId();
$ch["title"] = $channel->getTitle();
$ch["description"] = $channel->getDescription();
$ch["website"] = $channel->getWebsite();
$ch["classification"] = $channel->getClassification();
$ch["views"] = $channel->getViews();
$ch["shares"] = $channel->getShares();
$ch["playas"] = $channel->getPlayas();
$ch["rating"] = $channel->getRating();
$ch["comment"] = $channel->getComment();
$ch["image"] = $this['imagine']->filter($view['assets']->getUrl($channel->getMedia()->getLink()), 'channel_thumb');
$source_channel_list = array();
foreach ($channel->getSources() as $key => $source_channel) {
    $source_channel_obj = array();
    $source_channel_obj["id"] = $source_channel->getId();
    $source_channel_obj["quality"]=$source_channel->getQuality();
    $source_channel_obj["type"] = $source_channel->getType();
    $source_channel_obj["url"] = $source_channel->getUrl();

    $source_channel_list[] = $source_channel_obj;
}
$ch["sources"] = $source_channel_list;

$category_channel_list = array();
foreach ($channel->getCategories() as $key => $category_channel) {
    $category_channel_obj = array();
    $category_channel_obj["id"] = $category_channel->getId();
    $category_channel_obj["title"] = $category_channel->getTitle();
    $category_channel_list[] = $category_channel_obj;
}
$ch["categories"] = $category_channel_list;

if($channel->getCountry()!=null) {
    $country_channel_list = array();
    $country_channel_obj = array();
    $country_channel_obj["id"] = $channel->getCountry()->getId();
    $country_channel_obj["title"] = $channel->getCountry()->getTitle();
    $country_channel_obj["image"] = $this['imagine']->filter($view['assets']->getUrl($channel->getCountry()->getMedia()->getLink()), 'country_thumb');

    $country_channel_list[] = $country_channel_obj;
    $ch["country"] = $country_channel_list;
}else{
    $ch["country"] = null;
}

echo json_encode($ch, JSON_UNESCAPED_UNICODE);

?>