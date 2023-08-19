<?php 
$list=array();
foreach ($comments as $key => $comment) {
	$a["id"]=$comment->getId();
	$a["user"]=$comment->getUser()->getName();
	$a["content"]=$comment->getContent();
	$a["enabled"]=$comment->getEnabled();
          if($comment->getUser()->getMedia() ==  null ){
              $a["image"] = "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg" ;
          }else{
              if ($comment->getUser()->getMedia()->getType()=="link") {
                  $a["image"] = $comment->getUser()->getMedia()->getUrl() ;
              }else{
                  $a["image"] = $this['imagine']->filter($comment->getUser()->getMedia()->getLink(), 'actor_thumb') ;
              }
          }
	$a["created"]=$view['time']->diff($comment->getCreated());
	$list[]=$a;
}
echo json_encode($list, JSON_UNESCAPED_UNICODE);
?>