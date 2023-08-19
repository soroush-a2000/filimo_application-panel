<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Source;
use MediaBundle\Entity\Media;
use AppBundle\Form\SourceType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class SourceController extends Controller
{
 

    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $source=$em->getRepository("AppBundle:Source")->findOneBy(array("id"=>$id,"episode"=>null));
        if ($source==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$source->getPoster();

        if ($poster==null) {
            $poster=$em->getRepository("AppBundle:Poster")->findOneBy(array("trailer"=>$source));
            if($poster->getType()=="movie")
                $rout  = "app_movie_trailer";
            else
                $rout  = "app_serie_trailer";

        }else{
            if($poster->getType()=="movie")
                $rout  = "app_movie_sources";
            else
                $rout  = "app_serie_sources";
        }
        $choices = array(
            "youtube" => 1 ,
            "m3u8" => 2 ,
            "mov" => 3 ,
            "mp4"  => 4 ,
            "mkv"  => 6 ,
            "webm" => 7,
            "embed" => 8,
            "file" => 5 
        );
        $source->setType($choices[$source->getType()]);
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            if ($source->getType()==5) {
                if ($source->getFile()!=null ){
                    $media_old=$source->getMedia();


                    $sourcemedia= new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $source->setUrl(null);
                    $em->flush();  
                    if ($media_old) {
                        $media_old->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_old);
                        $em->flush();        
                    }
                }
            }else{
                if(strlen($source->getUrl())>1 ){
                    $media_old=$source->getMedia();

                    $source->setMedia(null);
                    $source->setType($choices[$source->getType()]);
                    $em->flush();

                    if ($media_old) {
                        $media_old->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_old);
                        $em->flush();        
                    }
                }
            }


            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl( $rout,array("id"=>$poster->getId())));
        }
        return $this->render("AppBundle:Source:edit.html.twig",array("rout"=> $rout,"poster"=>$poster,"form"=>$form->createView()));
    }
    public function edit_channelAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $source=$em->getRepository("AppBundle:Source")->findOneBy(array("id"=>$id,"poster"=>null,"episode"=>null));
        if ($source==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $channel=$source->getChannel();

        $rout  = "app_channel_sources";

        $choices = array(
            "youtube" => 1 ,
            "m3u8" => 2 ,
            "mov" => 3 ,
            "mp4"  => 4 ,
            "mkv"  => 6 ,
            "webm" => 7,
            "embed" => 8,
            "file" => 5 
        );
        $source->setType($choices[$source->getType()]);
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $choices = array(
                1 => "youtube",
                2 => "m3u8",
                3 => "mov",
                6 => "mkv",
                7 => "webm",
                8 => "embed",
                4 => "mp4"
            );

            if(strlen($source->getUrl())>1 ){
                $media_old=$source->getMedia();

                $source->setMedia(null);
                $source->setType($choices[$source->getType()]);
                $em->flush();

                if ($media_old) {
                    $media_old->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_old);
                    $em->flush();        
                }
            }
            


            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl( $rout,array("id"=>$channel->getId())));
        }
        return $this->render("AppBundle:Source:edit_channel.html.twig",array("rout"=> $rout,"channel"=>$channel,"form"=>$form->createView()));
    }
    public function edit_episodeAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $source=$em->getRepository("AppBundle:Source")->findOneBy(array("id"=>$id,"poster"=>null));
        if ($source==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $episode=$source->getEpisode();

        $rout  = "app_episode_sources";

        $choices = array(
            "youtube" => 1 ,
            "m3u8" => 2 ,
            "mov" => 3 ,
            "mp4"  => 4 ,
            "mkv"  => 6 ,
            "webm" => 7,
            "embed" => 8,
            "file" => 5 
        );
        $source->setType($choices[$source->getType()]);
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            if ($source->getType()==5) {
                if ($source->getFile()!=null ){
                    $media_old=$source->getMedia();


                    $sourcemedia= new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $source->setUrl(null);
                    $em->flush();  
                    if ($media_old) {
                        $media_old->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_old);
                        $em->flush();        
                    }
                }
            }else{
                if(strlen($source->getUrl())>1 ){
                    $media_old=$source->getMedia();

                    $source->setMedia(null);
                    $source->setType($choices[$source->getType()]);
                    $em->flush();

                    if ($media_old) {
                        $media_old->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_old);
                        $em->flush();        
                    }
                }
            }


            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl( $rout,array("id"=>$episode->getId())));
        }
        return $this->render("AppBundle:Source:edit_episode.html.twig",array("rout"=> $rout,"episode"=>$episode,"form"=>$form->createView()));
    }
    public function addAction(Request $request,$poster)
    {
        $em=$this->getDoctrine()->getManager();
        $poster=$em->getRepository("AppBundle:Poster")->find($poster);
        if ($poster==null) {
            throw new NotFoundHttpException("Page not found");
        }

            
        $rout  = "app_movie_sources";


        $source = new Source();
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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


            if ($source->getType()==5) {
                if ($source->getFile()!=null ){
                    $sourcemedia= new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $source->setPoster($poster);
                    $em->persist($source);
                    $em->flush();  
                }
            }else{
                if(strlen($source->getUrl())>1 ){
                    $source->setType($choices[$source->getType()]);
                    $em->persist($source);
                    $em->flush();
                    $source->setPoster($poster);
                }
            }

            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));
        }
        return $this->render("AppBundle:Source:add.html.twig",array("rout"=>$rout,"poster"=>$poster,"form"=>$form->createView()));
    }
    public function add_channelAction(Request $request,$channel)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->find($channel);
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }


        $rout  = "app_channel_sources";
    
        $source = new Source();
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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


            if ($source->getType()==5) {
                if ($source->getFile()!=null ){
                    $sourcemedia= new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $source->setChannel($channel);
                    $em->persist($source);
                    $em->flush();  
                }
            }else{
                if(strlen($source->getUrl())>1 ){
                    $source->setType($choices[$source->getType()]);
                    $em->persist($source);
                    $em->flush();
                    $source->setChannel($channel);
                }
            }

            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl($rout,array("id"=>$channel->getId())));
        }
        return $this->render("AppBundle:Source:add_channel.html.twig",array("rout"=>$rout,"channel"=>$channel,"form"=>$form->createView()));
    }
    public function add_episodeAction(Request $request,$episode)
    {
        $em=$this->getDoctrine()->getManager();
        $episode=$em->getRepository("AppBundle:Episode")->find($episode);
        if ($episode==null) {
            throw new NotFoundHttpException("Page not found");
        }


        $rout  = "app_episode_sources";
    
        $source = new Source();
        $form = $this->createForm(new SourceType(),$source);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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


            if ($source->getType()==5) {
                if ($source->getFile()!=null ){
                    $sourcemedia= new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $source->setEpisode($episode);
                    $em->persist($source);
                    $em->flush();  
                }
            }else{
                if(strlen($source->getUrl())>1 ){
                    $source->setType($choices[$source->getType()]);
                    $em->persist($source);
                    $em->flush();
                    $source->setEpisode($episode);
                }
            }

            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl($rout,array("id"=>$episode->getId())));
        }
        return $this->render("AppBundle:Source:add_episode.html.twig",array("rout"=>$rout,"episode"=>$episode,"form"=>$form->createView()));
    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();
        $source = $em->getRepository("AppBundle:Source")->find($id);
        if($source==null){
            throw new NotFoundHttpException("Page not found");
        }
        
        $movie=$source->getPoster();
        $episode=$source->getEpisode();
        $channel=$source->getChannel();

        if($movie!=null)
           $url = $this->generateUrl("app_movie_sources",array("id"=>$movie->getId()));
        if($episode!=null)
           $url =  $this->generateUrl("app_episode_sources",array("id"=>$episode->getId()));
        if($channel!=null)
           $url =  $this->generateUrl("app_channel_sources",array("id"=>$channel->getId()));

       if ($movie == null and $channel==null and $episode==null) {
           $movie =$em->getRepository("AppBundle:Poster")->findOneBy(array("trailer"=>$source));
           $url = $this->generateUrl("app_movie_trailer",array("id"=>$movie->getId()));
       }

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $movie =$em->getRepository("AppBundle:Poster")->findOneBy(array("trailer"=>$source));
            if ($movie != null) {
               $movie->setTrailer(null);
               $em->flush();
            }
            $media_old = $source->getMedia();
            $em->remove($source);
            $em->flush();
            if( $media_old!=null ){
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($url);
        }
        return $this->render('AppBundle:Source:delete.html.twig',array("url"=>$url,"form"=>$form->createView()));
    }

}
?>