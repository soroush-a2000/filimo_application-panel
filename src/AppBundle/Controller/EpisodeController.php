<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Source;
use AppBundle\Entity\Episode;
use MediaBundle\Entity\Media;
use AppBundle\Form\EpisodeType;
use AppBundle\Form\EditEpisodeType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class EpisodeController extends Controller
{
 

    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->findOneBy(array("id"=>$id));
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }

        $form = $this->createForm(new EditEpisodeType(),$episode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if ($episode->getFile()!=null ){

                    $media_cover_old = $episode->getMedia();


                    $episodemedia= new Media();
                    $episodemedia->setFile($episode->getFile());
                    $episodemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($episodemedia);
                    $em->flush();
                    $episode->setMedia($episodemedia);

                    if ($media_cover_old!=null) {
                        $media_cover_old->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_cover_old);
                        $em->flush();
                    }
                    
                }
                $em->flush();  
                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_serie_seasons',array("id"=>$episode->getSeason()->getPoster()->getId())));
           
        }

        return $this->render("AppBundle:Episode:edit.html.twig",array("season"=>$episode->getSeason(),"form"=>$form->createView()));
    }
    public function subtitlesAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($id);
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render("AppBundle:Episode:subtitles.html.twig",array("episode"=>$episode));
    }
    public function sourcesAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($id);
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }

        return $this->render("AppBundle:Episode:sources.html.twig",array("episode"=>$episode));
    }
    function get_image_mime_type($image_path)
    {
        $mimes  = array(
            IMAGETYPE_GIF => "image/gif",
            IMAGETYPE_JPEG => "image/jpg",
            IMAGETYPE_PNG => "image/png",
            IMAGETYPE_SWF => "image/swf",
            IMAGETYPE_PSD => "image/psd",
            IMAGETYPE_BMP => "image/bmp",
            IMAGETYPE_TIFF_II => "image/tiff",
            IMAGETYPE_TIFF_MM => "image/tiff",
            IMAGETYPE_JPC => "image/jpc",
            IMAGETYPE_JP2 => "image/jp2",
            IMAGETYPE_JPX => "image/jpx",
            IMAGETYPE_JB2 => "image/jb2",
            IMAGETYPE_SWC => "image/swc",
            IMAGETYPE_IFF => "image/iff",
            IMAGETYPE_WBMP => "image/wbmp",
            IMAGETYPE_XBM => "image/xbm",
            IMAGETYPE_ICO => "image/ico");

        if (($image_type = exif_imagetype($image_path))
            && (array_key_exists($image_type ,$mimes)))
        {
            return $mimes[$image_type];
        }
        else
        {
            return FALSE;
        }
    }
   function get_image_ext_type($image_path)
    {
        $mimes  = array(
            IMAGETYPE_GIF => "gif",
            IMAGETYPE_JPEG => "jpg",
            IMAGETYPE_PNG => "png",
            IMAGETYPE_SWF => "swf",
            IMAGETYPE_PSD => "psd",
            IMAGETYPE_BMP => "bmp",
            IMAGETYPE_TIFF_II => "tiff",
            IMAGETYPE_TIFF_MM => "tiff",
            IMAGETYPE_JPC => "jpc",
            IMAGETYPE_JP2 => "jp2",
            IMAGETYPE_JPX => "jpx",
            IMAGETYPE_JB2 => "jb2",
            IMAGETYPE_SWC => "swc",
            IMAGETYPE_IFF => "iff",
            IMAGETYPE_WBMP => "wbmp",
            IMAGETYPE_XBM => "xbm",
            IMAGETYPE_ICO => "ico");

        if (($image_type = exif_imagetype($image_path))
            && (array_key_exists($image_type ,$mimes)))
        {
            return $mimes[$image_type];
        }
        else
        {
            return FALSE;
        }
    }
    public function addAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository("AppBundle:Season")->findOneBy(array("id"=>$id));
        if ($season==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $episode = new Episode();
        $form = $this->createForm(new EpisodeType(),$episode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if ($episode->getFile()!=null ){
                    $episodemedia= new Media();
                    $episodemedia->setFile($episode->getFile());
                    $episodemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($episodemedia);
                    $em->flush();
                    $episode->setMedia($episodemedia);
                }else{
                    if (isset($_POST["image_url"]) and $_POST["image_url"]!=null and $_POST["image_url"]!="" and strpos($_POST["image_url"], 'http') === 0) {
                            $url =  $_POST["image_url"];
                            $fileName = md5(uniqid());
                            $fileType = $this->get_image_mime_type($url);
                            $fileExt = $this->get_image_ext_type($url);
                            $fullName = $fileName.".".$fileExt;

                            $uploadTo = $this->container->getParameter('files_directory').$fileExt."/".$fullName;

                            file_put_contents($uploadTo, file_get_contents($url)); 

                            $episodemedia= new Media();
                            $episodemedia->setType($fileType);
                            $episodemedia->setExtension($fileExt);
                            $episodemedia->setUrl($fullName);
                            $episodemedia->setTitre($episode->getTitle());
                            $em->persist($episodemedia);
                            $em->flush();
                            $episode->setMedia($episodemedia);
                    }
                }
                $max=0;
                $episodes=$em->getRepository('AppBundle:Episode')->findBy(array("season"=>$season));
                foreach ($episodes as $key => $value) {
                    if ($value->getPosition()>$max) {
                        $max=$value->getPosition();
                    }
                }
                $episode->setPosition($max+1);
                $episode->setSeason($season);
                $em->persist($episode);
                $em->flush();  
                    $choices = array(
                        1 => "youtube",
                        2 => "m3u8",
                        3 => "mov",
                        4 => "mp4",
                        6 => "mkv",
                        7 => "webm",
                        8 => "embed",
                        5 => "file"
                    );
                
                    if ($episode->getSourcetype()==5) {
                        if ($episode->getSourcefile()!=null ){
                            $mediasource= new Media();
                            $mediasource->setFile($episode->getSourcefile());
                            $mediasource->upload($this->container->getParameter('files_directory'));
                            $em->persist($mediasource);
                            $em->flush();

                            $source = new  Source();
                            $source->setType($choices[$episode->getSourcetype()]);
                            $source->setQuality($episode->getSourceQuality());
                            $source->setMedia($mediasource);
                            $source->setEpisode($episode);
                            $em->persist($source);
                            $em->flush();  
                        }
                    }else{
                        if(strlen($episode->getSourceurl())>1 ){
                            $source = new  Source();
                            $source->setType($choices[$episode->getSourcetype()]);
                            $source->setQuality($episode->getSourceQuality());
                            $source->setUrl($episode->getSourceurl());
                            $source->setEpisode($episode);
                            $em->persist($source);
                            $em->flush();
                        }
                    }

                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_episode_sources',array("id"=>$episode->getId())));
           
        }
        return $this->render("AppBundle:Episode:add.html.twig",array("season"=>$season,"form"=>$form->createView()));
    }
    public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($id);
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $season=$episode->getSeason();

        $rout =  'app_serie_seasons';
        if ($episode->getPosition()>1) {
                $p=$episode->getPosition();
                $episodes=$em->getRepository('AppBundle:Episode')->findBy(array("season"=>$season),array("position"=>"asc"));
                foreach ($episodes as $key => $value) {
                    if ($value->getPosition()==$p-1) {
                        $value->setPosition($p);  
                    }
                }
                $episode->setPosition($episode->getPosition()-1);
                $em->flush(); 
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$season->getPoster()->getId())));

    }
    public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($id);
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $season=$episode->getSeason();

        $rout =  'app_serie_seasons';

        $max=0;
        $episodes=$em->getRepository('AppBundle:Episode')->findBy(array("season"=>$season),array("position"=>"asc"));
        foreach ($episodes  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($episode->getPosition()<$max) {
            $p=$episode->getPosition();
            foreach ($episodes as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $episode->setPosition($episode->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$season->getPoster()->getId())));    

    }

    public function api_add_shareAction(Request $request, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $poster = $em->getRepository("AppBundle:Channel")->findOneBy(array("id"=>$id));
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster->setShares($poster->getShares() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($poster->getShares(), 'json');
        return new Response($jsonContent);
    }
    public function api_add_viewAction(Request $request, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $episode = $em->getRepository("AppBundle:Episode")->findOneBy(array("id"=>$id));
        if ($episode == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $episode->setViews($episode->getViews() + 1);
        $em->flush();
        $serie = $episode->getSeason()->getPoster();
        $views = 0;
        foreach ($serie->getSeasons() as $key => $season) {
            foreach ($season->getEpisodes() as $key => $value) {
                $views += $value->getViews();
            }
        }
        $serie->setViews($views);
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($episode->getViews(), 'json');
        return new Response($jsonContent);
    }
    public function api_add_downloadAction(Request $request, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $episode = $em->getRepository("AppBundle:Episode")->findOneBy(array("id"=>$id));
        if ($episode == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $episode->setDownloads($episode->getDownloads() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($episode->getDownloads(), 'json');
        return new Response($jsonContent);
    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $episode = $em->getRepository("AppBundle:Episode")->find($id);
        if($episode==null){
            throw new NotFoundHttpException("Page not found");
        }
        
        $season=$episode->getSeason();
        $url = $this->generateUrl('app_serie_seasons',array("id"=>$season->getPoster()->getId()));
        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
             $season = $episode->getSeason();
            foreach ($episode->getSources() as $key => $source) {
                $media_source = $source->getMedia();
                $em->remove($source);
                $em->flush();

                if ($media_source!=null) {
                    $media_source->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_source);
                    $em->flush();
                }
            }
            foreach ($episode->getSubtitles() as $key => $subtitle) {
                $media_subtitle = $subtitle->getMedia();
                
                $em->remove($subtitle);
                $em->flush();

                if ($media_subtitle!=null) {
                    $media_subtitle->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_subtitle);
                    $em->flush();
                }
            }
            $media_episode = $episode->getMedia();

            $em->remove($episode);
            $em->flush();

            if ($media_episode!=null) {
                $media_episode->delete($this->container->getParameter('files_directory'));
                $em->remove($media_episode);
                $em->flush();
            }

            $serie = $season->getPoster();
            $views = 0;

            foreach ($season->getEpisodes() as $key => $value) {
                $views += $value->getViews();
            }
            
            $serie->setViews($views);
            $em->flush();

            $episodes =  $em->getRepository("AppBundle:Episode")->findBy(array("season"=>$season),array("position"=>"asc"));
            $position = 0;
            foreach ($episodes as $key => $ep) {
                $position ++;
                $ep->setPosition($position);
                $em->flush();
            }

            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($url);
        }
        return $this->render('AppBundle:Episode:delete.html.twig',array("url"=>$url,"form"=>$form->createView()));
    }

}
?>