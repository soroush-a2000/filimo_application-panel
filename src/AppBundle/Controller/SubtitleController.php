<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Subtitle;
use MediaBundle\Entity\Media;
use AppBundle\Form\SubtitleType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class SubtitleController extends Controller
{
 

 
    
    public function api_by_episodeAction(Request $request,$token,$id)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();

       $episode = $em->getRepository('AppBundle:Episode')->find($id);
       if($episode==null){
            throw new NotFoundHttpException("Page not found");  
       }

       $languages = $em->getRepository('AppBundle:Language')->findAll();
       $languages_list =  array();
       foreach ($languages as $key => $language) {
            $subtitles = $em->getRepository('AppBundle:Subtitle')->findBy(array("episode"=>$episode,"language"=>$language));
            if (sizeof($subtitles)>0) {
               $l["id"]=$language->getId();
               $l["image"]=$imagineCacheManager->getBrowserPath($language->getMedia()->getLink(), 'category_thumb_api');
               $l["language"]=$language->getLanguage();
               $subtitles_list = array();
               foreach ($subtitles as $key => $subtitle) {
                    $s["id"]=$subtitle->getId();
                    $s["type"]=$subtitle->getMedia()->getExtension();
                    $s["url"]=$request->getScheme() . "://" .$request->getHttpHost().$this->generateUrl('api_subtitle_by_id',array("id"=>$subtitle->getId(),"token"=>$token));
                    $subtitles_list[]=$s;
               }
               $l["subtitles"]=$subtitles_list;
               $languages_list[] = $l;
            }
       }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($languages_list, 'json');
        return new Response($jsonContent);
    }
    public function api_by_idAction(Request $request,$token,$id)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

       $subtitle = $em->getRepository('AppBundle:Subtitle')->find($id);
       if($subtitle==null){
            throw new NotFoundHttpException("Page not found");  
       }
       $media = $subtitle->getMedia();
        $file_name = $media->getLink();
        $result = file_get_contents($media->getLink());

        header("Content-Type:text/vtt;charset=utf-8");
        header('Access-Control-Allow-Origin: *');  
        header("Access-Control-Max-Age: 3628800");
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("Access-Control-Allow-Headers: Authorization");

        echo $result;
        return new Response("");
      // return $this->render("AppBundle:Subtitle:show.html.php",array("subtitle"=>$subtitle));
    }
    public function api_by_movieAction(Request $request,$token,$id)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();

       $poster = $em->getRepository('AppBundle:Poster')->find($id);
       if($poster==null){
            throw new NotFoundHttpException("Page not found");  
       }

       $languages = $em->getRepository('AppBundle:Language')->findAll();
       $languages_list =  array();
       foreach ($languages as $key => $language) {
            $subtitles = $em->getRepository('AppBundle:Subtitle')->findBy(array("poster"=>$poster,"language"=>$language));
            if (sizeof($subtitles)>0) {
               $l["id"]=$language->getId();
               $l["image"]=$imagineCacheManager->getBrowserPath($language->getMedia()->getLink(), 'category_thumb_api');
               $l["language"]=$language->getLanguage();
               $subtitles_list = array();
               foreach ($subtitles as $key => $subtitle) {
                    $s["id"]=$subtitle->getId();
                    $s["type"]=$subtitle->getMedia()->getExtension();
                    $s["url"]=$request->getScheme() . "://" .$request->getHttpHost().$this->generateUrl('api_subtitle_by_id',array("id"=>$subtitle->getId(),"token"=>$token));
                    $subtitles_list[]=$s;
               }
               $l["subtitles"]=$subtitles_list;
               $languages_list[] = $l;
            }
       }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($languages_list, 'json');
        return new Response($jsonContent);
    }
    public function addAction(Request $request,$poster)
    {
        $em=$this->getDoctrine()->getManager();
        $movie=$em->getRepository("AppBundle:Poster")->find($poster);

        if ($movie==null) {
            throw new NotFoundHttpException("Page not found");
        }

        $subtitle = new Subtitle();
        $form = $this->createForm(new SubtitleType(),$subtitle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($subtitle->getFile()!=null ){
                $subtitlemedia= new Media();
                $subtitlemedia->setFile($subtitle->getFile());
                $subtitlemedia->upload($this->container->getParameter('files_directory'));
                $em->persist($subtitlemedia);
                $em->flush();
                $subtitle->setMedia($subtitlemedia);
                $subtitle->setPoster($movie);
                $em->persist($subtitle);
                $em->flush();  
               /* if ($subtitle->getFile()->getClientOriginalExtension() == "srt") {
                    $media = $subtitle->getMedia();

                    $file_name = $media->getLink();
                    $result = file_get_contents($media->getLink());
                    
                    $op1 = str_replace(",", ".", $result);
                    
                    $file_name_vtt = str_replace( "srt", "vtt",$file_name);
                    $txt = "WEBVTT\n\n";
                    $txt .= $op1;
                    $myfile = fopen($file_name_vtt, "w");
                    fwrite($myfile, $txt);
                    fclose($myfile);

                    $media->setUrl(str_replace("srt","vtt",$media->getUrl()));
                    $media->setExtension(str_replace("srt","vtt",$media->getExtension()));
                    $media->setType(str_replace("srt","vtt",$media->getType()));
                    $em->flush();  
                    sleep(1);
                    @unlink($file_name);

                }*/
                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_movie_subtitles',array("id"=>$movie->getId())));
            }else{
                $error = new FormError("باید یک تصویر انتخاب نمایید!");
                $form->get('file')->addError($error);
            }
        }
        return $this->render("AppBundle:Subtitle:add.html.twig",array("movie"=>$movie,"form"=>$form->createView()));
    }
    public function add_episodeAction(Request $request,$episode)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($episode);

        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }

        $subtitle = new Subtitle();
        $form = $this->createForm(new SubtitleType(),$subtitle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($subtitle->getFile()!=null ){
                $subtitlemedia= new Media();
                $subtitlemedia->setFile($subtitle->getFile());
                $subtitlemedia->upload($this->container->getParameter('files_directory'));
                $em->persist($subtitlemedia);
                $em->flush();
                $subtitle->setMedia($subtitlemedia);
                $subtitle->setEpisode($episode);
                $em->persist($subtitle);
                $em->flush();  

              /*  if ($subtitle->getFile()->getClientOriginalExtension() == "srt") {
                    $media = $subtitle->getMedia();

                    $file_name = $media->getLink();
                    $result = file_get_contents($media->getLink());
                    
                    $op1 = str_replace(",", ".", $result);
                    
                    $file_name_vtt = str_replace( "srt", "vtt",$file_name);
                    $txt = "WEBVTT\n\n";
                    $txt .= $op1;
                    $myfile = fopen($file_name_vtt, "w");
                    fwrite($myfile, $txt);
                    fclose($myfile);

                    $media->setUrl(str_replace("srt","vtt",$media->getUrl()));
                    $media->setExtension(str_replace("srt","vtt",$media->getExtension()));
                    $media->setType(str_replace("srt","vtt",$media->getType()));
                    $em->flush();  
                    sleep(1);
                    @unlink($file_name);

                }
            */
                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_episode_subtitles',array("id"=>$episode->getId())));
            }else{
                $error = new FormError("باید یک تصویر انتخاب نمایید!");
                $form->get('file')->addError($error);
            }
        }
        return $this->render("AppBundle:Subtitle:add_episode.html.twig",array("episode"=>$episode,"form"=>$form->createView()));
    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $subtitle = $em->getRepository("AppBundle:Subtitle")->find($id);
        if($subtitle==null){
            throw new NotFoundHttpException("Page not found");
        }
        
        $movie=$subtitle->getPoster();
        $episode=$subtitle->getEpisode();

        if($movie!=null)
           $url = $this->generateUrl("app_movie_subtitles",array("id"=>$movie->getId()));
        if($episode!=null)
           $url =  $this->generateUrl("app_episode_subtitles",array("id"=>$episode->getId()));


        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $media_old = $subtitle->getMedia();
            $em->remove($subtitle);
            $em->flush();
            if( $media_old!=null ){
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($url);
        }
        return $this->render('AppBundle:Subtitle:delete.html.twig',array("url"=>$url,"form"=>$form->createView()));
    }

}
?>