<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Season;
use MediaBundle\Entity\Media;
use AppBundle\Form\SeasonType;
use AppBundle\Form\EditSeasonType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class SeasonController extends Controller
{
     public function api_by_serieAction(Request $request,$id,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $serie=$em->getRepository("AppBundle:Poster")->findOneBy(array("type"=>"serie","id"=>$id));
        if ($serie==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $seasons =   $em->getRepository("AppBundle:Season")->findBy(array("poster"=>$serie),array("position"=>"asc"));
        return $this->render('AppBundle:Season:api_all.html.php', array("seasons" => $seasons));
    }

    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository("AppBundle:Season")->findOneBy(array("id"=>$id));
        if ($season==null) {
            throw new NotFoundHttpException("Page not found");
        }

        $form = $this->createForm(new SeasonType(),$season);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();  
                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_serie_seasons',array("id"=>$season->getPoster()->getId())));
        }
        return $this->render("AppBundle:Season:edit.html.twig",array("season"=>$season,"form"=>$form->createView()));
    }
    

    public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository("AppBundle:Season")->find($id);
        if ($season==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$season->getPoster();

        $rout =  'app_serie_seasons';
        if ($season->getPosition()>1) {
                $p=$season->getPosition();
                $seasons=$em->getRepository('AppBundle:Season')->findBy(array("poster"=>$poster),array("position"=>"asc"));
                foreach ($seasons as $key => $value) {
                    if ($value->getPosition()==$p-1) {
                        $value->setPosition($p);  
                    }
                }
                $season->setPosition($season->getPosition()-1);
                $em->flush(); 
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));

    }
    public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository("AppBundle:Season")->find($id);
        if ($season==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$season->getPoster();

        $rout =  'app_serie_seasons';

        $max=0;
        $seasons=$em->getRepository('AppBundle:Season')->findBy(array("poster"=>$poster),array("position"=>"asc"));
        foreach ($seasons  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($season->getPosition()<$max) {
            $p=$season->getPosition();
            foreach ($seasons as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $season->setPosition($season->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));    

    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $season = $em->getRepository("AppBundle:Season")->find($id);
        if($season==null){
            throw new NotFoundHttpException("Page not found");
        }
        
        $serie=$season->getPoster();

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            foreach ($season->getEpisodes() as $key => $episode) {
            
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
            }
            $em->remove($season);
            $em->flush();


            $seasons =  $em->getRepository("AppBundle:Season")->findBy(array("poster"=>$serie),array("position"=>"asc"));
            $position = 0;
            foreach ($seasons as $key => $sea) {
                $position ++;
                $sea->setPosition($position);
                $em->flush();
            }


            $views = 0;
            foreach ($serie->getSeasons() as $key => $season) {
                foreach ($season->getEpisodes() as $key => $value) {
                    $views += $value->getViews();
                }
            }
            $serie->setViews($views);
            $em->flush();

            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_serie_seasons',array("id"=>$serie->getId())));
        }
        return $this->render('AppBundle:Season:delete.html.twig',array("serie"=>$serie,"form"=>$form->createView()));
    }

}
?>