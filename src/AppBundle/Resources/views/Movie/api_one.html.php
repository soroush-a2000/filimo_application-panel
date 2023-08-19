<?php

$pstr = null;
$pstr["id"] = $poster->getId();
$pstr["title"] = $poster->getTitle();
$pstr["type"] = $poster->getType();
$pstr["description"] = $poster->getDescription();
$pstr["year"] = $poster->getYear();
$pstr["rating"] = $poster->getRating();
$pstr["duration"] = $poster->getDuration();
$pstr["downloadas"] = $poster->getDownloadas();
$pstr["imdb"] = $poster->getImdb();
$pstr["comment"] = $poster->getComment();
$pstr["playas"] = $poster->getPlayas();
$pstr["classification"] = $poster->getClassification();
$pstr["image"] = $this['imagine']->filter($view['assets']->getUrl($poster->getPoster()->getLink()), 'poster_thumb');
if ($poster->getCover())
    $pstr["cover"] = $this['imagine']->filter($view['assets']->getUrl($poster->getCover()->getLink()), 'cover_thumb');


$genre_poster_list = array();
foreach ($poster->getGenres() as $key => $genre_poster) {
    $genre_poster_obj = array();
    $genre_poster_obj["id"] = $genre_poster->getId();
    $genre_poster_obj["title"] = $genre_poster->getTitle();
    $genre_poster_list[] = $genre_poster_obj;
}
$pstr["genres"] = $genre_poster_list;

if ($poster->getTrailer()) {
    $trailer_poster_obj["id"] = $poster->getTrailer()->getId();
    if ($poster->getTrailer()->getType() == "file") {
        $trailer_poster_obj["url"] = $app->getRequest()->getScheme() . "://" . $app->getRequest()->getHttpHost() . "/" . $poster->getTrailer()->getMedia()->getLink();
        $trailer_poster_obj["type"] = $poster->getTrailer()->getMedia()->getExtension();

    } else {
        $trailer_poster_obj["type"] = $poster->getTrailer()->getType();
        $trailer_poster_obj["url"] = $poster->getTrailer()->getUrl();
    }
    $pstr["trailer"] = $trailer_poster_obj;
}
$source_poster_list = array();
foreach ($poster->getSources() as $key => $source_poster) {
    $source_poster_obj = array();
    $source_poster_obj["id"] = $source_poster->getId();
    $source_poster_obj["quality"]=$source_poster->getQuality();
    if ($source_poster->getType() == "file") {
        $source_poster_obj["url"] = $app->getRequest()->getScheme() . "://" . $app->getRequest()->getHttpHost() . "/" . $source_poster->getMedia()->getLink();
        $source_poster_obj["type"] = $source_poster->getMedia()->getExtension();

    } else {
        $source_poster_obj["type"] = $source_poster->getType();
        $source_poster_obj["url"] = $source_poster->getUrl();
    }
    $source_poster_list[] = $source_poster_obj;
}
$pstr["sources"] = $source_poster_list;

if($poster->getCountry()!=null) {
    $country_poster_list = array();
    $country_poster_obj = array();
    $country_poster_obj["id"] = $poster->getCountry()->getId();
    $country_poster_obj["title"] = $poster->getCountry()->getTitle();
    $country_poster_obj["image"] = $this['imagine']->filter($view['assets']->getUrl($poster->getCountry()->getMedia()->getLink()), 'country_thumb');

    $country_poster_list[] = $country_poster_obj;
    $pstr["country"] = $country_poster_list;
}else{
    $pstr["country"] = null;
}



echo json_encode($pstr, JSON_UNESCAPED_UNICODE);
?>