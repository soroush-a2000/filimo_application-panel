<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Genre;
use MediaBundle\Entity\Media;
use AppBundle\Form\GenreType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class GenreController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genres =   $em->getRepository("AppBundle:Genre")->findBy(array(),array("position"=>"asc"));
        return $this->render("AppBundle:Genre:index.html.twig",array("genres"=>$genres));
    }


    public function api_allAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();
        $genres =   $em->getRepository("AppBundle:Genre")->findBy(array(),array("position"=>"asc"));
        foreach ($genres as $key => $genre) {
            $s["id"]=$genre->getId();
            $s["title"]=$genre->getTitle();
            $list[]=$s;
        }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($list, 'json');
        return new Response($jsonContent);
    }
    public function api_by_sectionAction(Request $request,$id,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $section=$em->getRepository("AppBundle:Section")->find($id);

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();
        $genres =   $em->getRepository("AppBundle:Genre")->findBy(array("section"=>$section),array("position"=>"asc"));
        foreach ($genres as $key => $genre) {
            $s["id"]=$genre->getId();
            $s["title"]=$genre->getTitle();
            $s["image"]=$imagineCacheManager->getBrowserPath( $genre->getMedia()->getLink(), 'section_thumb_api');
            $list[]=$s;
        }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($list, 'json');
        return new Response($jsonContent);
    }
    
    public function addAction(Request $request)
    {
        $genre= new Genre();
        $form = $this->createForm(new GenreType(),$genre);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                    $max=0;
                    $genres=$em->getRepository('AppBundle:Genre')->findAll();
                    foreach ($genres as $key => $value) {
                        if ($value->getPosition()>$max) {
                            $max=$value->getPosition();
                        }
                    }
                    $genre->setPosition($max+1);
                    $em->persist($genre);
                    $em->flush();
                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_genre_index'));

       }
        return $this->render("AppBundle:Genre:add.html.twig",array("form"=>$form->createView()));
    }

    public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $genre=$em->getRepository("AppBundle:Genre")->find($id);
        if ($genre==null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($genre->getPosition()>1) {
            $p=$genre->getPosition();
            $genres=$em->getRepository('AppBundle:Genre')->findAll();
            foreach ($genres as $key => $value) {
                if ($value->getPosition()==$p-1) {
                    $value->setPosition($p);  
                }
            }
            $genre->setPosition($genre->getPosition()-1);
            $em->flush(); 
        }
        return $this->redirect($this->generateUrl('app_genre_index'));
    }
    public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $genre=$em->getRepository("AppBundle:Genre")->find($id);
        if ($genre==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $max=0;
        $genres=$em->getRepository('AppBundle:Genre')->findBy(array(),array("position"=>"asc"));
        foreach ($genres  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($genre->getPosition()<$max) {
            $p=$genre->getPosition();
            foreach ($genres as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $genre->setPosition($genre->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl('app_genre_index'));
    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $genre = $em->getRepository("AppBundle:Genre")->find($id);
        if($genre==null){
            throw new NotFoundHttpException("Page not found");
        }

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $genres=$em->getRepository('AppBundle:Genre')->findBy(array(),array("position"=>"asc"));
            $em->remove($genre);
            $em->flush();

            $p=1;
            foreach ($genres as $key => $value) {
                $value->setPosition($p); 
                $p++; 
            }
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_genre_index'));
        }
        return $this->render('AppBundle:Genre:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $genre=$em->getRepository("AppBundle:Genre")->find($id);
        if ($genre==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new GenreType(),$genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($genre);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_genre_index'));
 
        }
        return $this->render("AppBundle:Genre:edit.html.twig",array("genre"=>$genre,"form"=>$form->createView()));
    }
}
?>