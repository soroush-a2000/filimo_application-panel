<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Package;
use AppBundle\Form\PackageType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class PackageController extends Controller
{
    public function indexAction(Request $request)
    {


        $em= $this->getDoctrine()->getManager();
        $dql        = "SELECT p FROM AppBundle:Package p ORDER BY p.id asc";
        $query      = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        $packages= $em->getRepository('AppBundle:Package')->findAll();
        return $this->render('AppBundle:Package:index.html.twig',
            array(
                'pagination' => $pagination,
                "packages"=> $packages
            )
        );

    }

    public function api_allAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $list=array();
       // $packages =   $em->getRepository("AppBundle:Package")->findBy(array(),array("position"=>"asc"));
        $packages =   $em->getRepository("AppBundle:Package")->findBy(array("enabled"=>true),array("id"=>"asc"));
        foreach ($packages as $key => $package) {
            $s["id"]=$package->getId();
            $s["title"]=$package->getTitle();
            $s["days"]=$package->getDays();
            $s["skukey"]=$package->getSkuKey();
            $s["price"]=$package->getPrice();
            if($package->getPriceOff()== null){
                $s["priceoff"]="0";
            }else{
                $s["priceoff"]=$package->getPriceOff();
            }

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
        $package= new Package();
        $form = $this->createForm(new PackageType(),$package);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                
/*                    $max=0;
                    $packages=$em->getRepository('AppBundle:Package')->findAll();
                    foreach ($packages as $key => $value) {
                        if ($value->getPosition()>$max) {
                            $max=$value->getPosition();
                        }
                    }
                    $package->setPosition($max+1);*/
                    $em->persist($package);
                    $em->flush();
                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_package_index'));

       }
        return $this->render("AppBundle:Package:add.html.twig",array("form"=>$form->createView()));
    }

    /* public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $package=$em->getRepository("AppBundle:Package")->find($id);
        if ($package==null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($package->getPosition()>1) {
            $p=$package->getPosition();
            $packages=$em->getRepository('AppBundle:Package')->findAll();
            foreach ($packages as $key => $value) {
                if ($value->getPosition()==$p-1) {
                    $value->setPosition($p);  
                }
            }
            $package->setPosition($package->getPosition()-1);
            $em->flush(); 
        }
        return $this->redirect($this->generateUrl('app_package_index'));
    }
   public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $package=$em->getRepository("AppBundle:Package")->find($id);
        if ($package==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $max=0;
        $packages=$em->getRepository('AppBundle:Package')->findBy(array(),array("position"=>"asc"));
        foreach ($packages  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($package->getPosition()<$max) {
            $p=$package->getPosition();
            foreach ($packages as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $package->setPosition($package->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl('app_package_index'));
    }*/
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $package = $em->getRepository("AppBundle:Package")->find($id);
        if($package==null){
            throw new NotFoundHttpException("Page not found");
        }

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($package);
/*            $packages=$em->getRepository('AppBundle:Package')->findBy(array(),array("position"=>"asc"));

            $p=1;
            foreach ($packages as $key => $value) {
                $value->setPosition($p); 
                $p++; 
            }*/
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_package_index'));
        }
        return $this->render('AppBundle:Package:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $package=$em->getRepository("AppBundle:Package")->find($id);
        if ($package==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new PackageType(),$package);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($package);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_package_index'));
 
        }
        return $this->render("AppBundle:Package:edit.html.twig",array("package"=>$package,"form"=>$form->createView()));
    }
}
?>