<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Role;
use MediaBundle\Entity\Media;
use AppBundle\Form\RoleType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class RoleController extends Controller
{
 

    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $role=$em->getRepository("AppBundle:Role")->find($id);
        if ($role==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$role->getPoster();

        $rout =  'app_movie_cast';
        if ($poster->getType()=="serie") 
            $rout =  'app_serie_cast';

        $form = $this->createForm(new RoleType(),$role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));
        }
        return $this->render("AppBundle:Role:edit.html.twig",array("rout"=>$rout,"poster"=>$poster,"form"=>$form->createView()));
    }
    public function api_by_posterAction(Request $request,$token,$id)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();
        $poster=$em->getRepository("AppBundle:Poster")->find($id);

        $roles =   $em->getRepository("AppBundle:Role")->findBy(array("poster"=>$poster),array("position"=>"asc"));
        foreach ($roles as $key => $role) {
            $s["id"]=$role->getActor()->getId();
            $s["name"]=$role->getActor()->getName();
            $s["bio"]=$role->getActor()->getBio();
            $s["height"]=$role->getActor()->getHeight();
            $s["born"]=$role->getActor()->getBorn();
            $s["image"]=$imagineCacheManager->getBrowserPath( $role->getActor()->getMedia()->getLink(), 'actor_thumb');
            $s["role"]=$role->getRole();
            $list[]=$s;
        }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($list, 'json');
        return new Response($jsonContent);
    }
    public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $role=$em->getRepository("AppBundle:Role")->find($id);
        if ($role==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$role->getPoster();

        $rout =  'app_movie_cast';
        if ($poster->getType()=="serie") 
            $rout =  'app_serie_cast';
        if ($role->getPosition()>1) {
                $p=$role->getPosition();
                $roles=$em->getRepository('AppBundle:Role')->findBy(array("poster"=>$poster),array("position"=>"asc"));
                foreach ($roles as $key => $value) {
                    if ($value->getPosition()==$p-1) {
                        $value->setPosition($p);  
                    }
                }
                $role->setPosition($role->getPosition()-1);
                $em->flush(); 
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));

    }
    public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $role=$em->getRepository("AppBundle:Role")->find($id);
        if ($role==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$role->getPoster();

        $rout =  'app_movie_cast';
        if ($poster->getType()=="serie") 
            $rout =  'app_serie_cast';

        $max=0;
        $roles=$em->getRepository('AppBundle:Role')->findBy(array("poster"=>$poster),array("position"=>"asc"));
        foreach ($roles  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($role->getPosition()<$max) {
            $p=$role->getPosition();
            foreach ($roles as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $role->setPosition($role->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));    

    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $role = $em->getRepository("AppBundle:Role")->find($id);
        if($role==null){
            throw new NotFoundHttpException("Page not found");
        }

        $poster=$role->getPoster();

        $rout =  'app_movie_cast';
        if ($poster->getType()=="serie") 
            $rout =  'app_serie_cast';
        
        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($role);
            $em->flush();

            $roles=$em->getRepository('AppBundle:Role')->findBy(array("poster"=>$poster),array("position"=>"asc"));

            $p=1;
            foreach ($roles as $key => $value) {
                $value->setPosition($p); 
                $p++; 
            }
            $em->flush();

            $this->addFlash('success', 'عملیات با موفقیت انجام شد');

            return $this->redirect($this->generateUrl($rout,array("id"=>$poster->getId())));

        }
        return $this->render('AppBundle:Role:delete.html.twig',array("rout"=>$rout,"poster"=>$poster,"form"=>$form->createView()));
    }

}
?>