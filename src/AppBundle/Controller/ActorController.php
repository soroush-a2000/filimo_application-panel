<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Actor;
use MediaBundle\Entity\Media;
use AppBundle\Form\ActorType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class ActorController extends Controller
{
    public function api_allAction(Request $request,$search,$page,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();
        $nombre = 30;
        $repository = $em->getRepository('AppBundle:Actor');
        $query_builder = $repository->createQueryBuilder('A')
            ->select(array("A.id","A.name","A.bio","A.height","A.born","m.url as image","m.extension as extension","SUM(P.views) as test"))
            ->leftJoin('A.roles', 'G')
            ->leftJoin('G.poster', 'P')
            ->leftJoin('A.media', 'm')
            ->groupBy('A.id')
            ->groupBy('A.id')
            ->orderBy('test',"DESC")
            ->setFirstResult($nombre * $page)
            ->setMaxResults($nombre);
           
        if($search!="null"){
            $query_builder->where("A.name like '%".$search."%'");
            $query=$query_builder->getQuery();
        }else{
            $query=$query_builder->getQuery();
        }
        $actors = $query->getResult();

        foreach ($actors as $key => $actor) {
            $s["id"]=$actor["id"];
            $s["name"]=$actor["name"];
            $s["bio"]=$actor["bio"];
            $s["height"]=$actor["height"];
            $s["born"]=$actor["born"];
            $media =  new Media();
            $s["image"]=$imagineCacheManager->getBrowserPath("uploads/".$actor["extension"]."/".$actor["image"], 'actor_thumb');
            $list[]=$s;
        }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($list, 'json');
        return new Response($jsonContent);
    }
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $q = " 1=1 ";
        if ($request->query->has("q") and $request->query->get("q") != "") {
            $q .= " AND  a.name like '%" . $request->query->get("q") . "%'";
        }

        $dql = "SELECT a FROM AppBundle:Actor a  WHERE  " . $q . " ORDER BY a.id desc ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $actors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );
        $actors_count = $em->getRepository('AppBundle:Actor')->count();
        return $this->render('AppBundle:Actor:index.html.twig', array("actors_count" => $actors_count, "actors" => $actors));
    }
    
    public function addAction(Request $request)
    {
        $actor= new Actor();
        $form = $this->createForm(new ActorType(),$actor);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if( $actor->getFile()!=null ){
                    $media= new Media();
                    $media->setFile($actor->getFile());
                    $media->upload($this->container->getParameter('files_directory'));
                    $em->persist($media);
                    $em->flush();
                    $actor->setMedia($media);
                    $em->persist($actor);
                    $em->flush();
                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_actor_index'));
                }else{
                    $error = new FormError("باید یک تصویر انتخاب نمایید!");
                    $form->get('file')->addError($error);
                }
       }
       return $this->render("AppBundle:Actor:add.html.twig",array("form"=>$form->createView()));
    }

    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $actor = $em->getRepository("AppBundle:Actor")->find($id);
        if($actor==null){
            throw new NotFoundHttpException("Page not found");
        }
        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $media_old = $actor->getMedia();
            $em->remove($actor);
            $em->flush();
            if( $media_old!=null ){
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_actor_index'));
        }
        return $this->render('AppBundle:Actor:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $actor=$em->getRepository("AppBundle:Actor")->find($id);
        if ($actor==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new ActorType(),$actor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if( $actor->getFile()!=null ){
                $media= new Media();
                $media_old=$actor->getMedia();
                $media->setFile($actor->getFile());
                $media->upload($this->container->getParameter('files_directory'));
                $em->persist($media);
                $em->flush();
                $actor->setMedia($media);
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $em->persist($actor);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_actor_index'));
 
        }
        return $this->render("AppBundle:Actor:edit.html.twig",array("actor"=>$actor,"form"=>$form->createView()));
    }
}
?>