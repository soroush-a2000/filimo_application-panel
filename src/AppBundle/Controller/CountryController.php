<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Country;
use MediaBundle\Entity\Media;
use AppBundle\Form\CountryType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class CountryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $countries =   $em->getRepository("AppBundle:Country")->findBy(array(),array());
        return $this->render("AppBundle:Country:index.html.twig",array("countries"=>$countries));
    }
    public function api_allAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $list=array();
        $countries =   $em->getRepository("AppBundle:Country")->findBy(array(),array("title"=>"asc"));
        foreach ($countries as $key => $country) {
            $s["id"]=$country->getId();
            $s["title"]=$country->getTitle();
            $s["image"]=$imagineCacheManager->getBrowserPath( $country->getMedia()->getLink(), 'country_thumb');
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
        $countries =   $em->getRepository("AppBundle:Country")->findBy(array("section"=>$section),array("position"=>"asc"));
        foreach ($countries as $key => $country) {
            $s["id"]=$country->getId();
            $s["title"]=$country->getTitle();
            $s["image"]=$imagineCacheManager->getBrowserPath( $country->getMedia()->getLink(), 'section_thumb_api');
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
        $country= new Country();
        $form = $this->createForm(new CountryType(),$country);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if( $country->getFile()!=null ){
                    $media= new Media();
                    $media->setFile($country->getFile());
                    $media->upload($this->container->getParameter('files_directory'));
                    $em->persist($media);
                    $em->flush();
                    $country->setMedia($media);

                    $em->persist($country);
                    $em->flush();
                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_country_index'));
                }else{
                    $error = new FormError("باید یک تصویر انتخاب نمایید!");
                    $form->get('file')->addError($error);
                }
       }
        return $this->render("AppBundle:Country:add.html.twig",array("form"=>$form->createView()));
    }

    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $country = $em->getRepository("AppBundle:Country")->find($id);
        if($country==null){
            throw new NotFoundHttpException("Page not found");
        }

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $media_old = $country->getMedia();
            $em->remove($country);
            $em->flush();
            if( $media_old!=null ){
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_country_index'));
        }
        return $this->render('AppBundle:Country:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $country=$em->getRepository("AppBundle:Country")->find($id);
        if ($country==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new CountryType(),$country);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if( $country->getFile()!=null ){
                $media= new Media();
                $media_old=$country->getMedia();
                $media->setFile($country->getFile());
                $media->upload($this->container->getParameter('files_directory'));
                $em->persist($media);
                $em->flush();
                $country->setMedia($media);

                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $em->persist($country);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_country_index'));
 
        }
        return $this->render("AppBundle:Country:edit.html.twig",array("country"=>$country,"form"=>$form->createView()));
    }
}
?>