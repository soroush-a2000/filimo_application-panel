<?php 
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use MediaBundle\Entity\Media;
use AppBundle\Form\CategoryType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class CategoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories =   $em->getRepository("AppBundle:Category")->findBy(array(),array("position"=>"asc"));
        return $this->render("AppBundle:Category:index.html.twig",array("categories"=>$categories));
    }
    public function api_popularAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();
        $list=array();

       $repository = $em->getRepository('AppBundle:Category');

        $query = $repository->createQueryBuilder('C')
          ->select(array("C.id","C.title","m.url as image","m.extension as extension","SUM(w.downloads) as test"))
          ->leftJoin('C.status', 'w')
          ->leftJoin('C.media', 'm')
          ->groupBy('C.id')
          ->orderBy('test',"DESC")
          ->where('w.enabled=true')
          ->getQuery();

        $categories = $query->getResult();

        foreach ($categories as $key => $category) {
            $s["id"]=$category["id"];
            $s["title"]=$category["title"];
            $list[]=$s;
        }
        header('Content-Type: application/json'); 
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($list, 'json');
        return new Response($jsonContent);
    }
    public function api_allAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $list=array();
        $categories =   $em->getRepository("AppBundle:Category")->findBy(array(),array("position"=>"asc"));
        foreach ($categories as $key => $category) {
            $s["id"]=$category->getId();
            $s["title"]=$category->getTitle();
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
        $category= new Category();
        $form = $this->createForm(new CategoryType(),$category);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                
                    $max=0;
                    $categories=$em->getRepository('AppBundle:Category')->findAll();
                    foreach ($categories as $key => $value) {
                        if ($value->getPosition()>$max) {
                            $max=$value->getPosition();
                        }
                    }
                    $category->setPosition($max+1);
                    $em->persist($category);
                    $em->flush();
                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_category_index'));

       }
        return $this->render("AppBundle:Category:add.html.twig",array("form"=>$form->createView()));
    }

    public function upAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $category=$em->getRepository("AppBundle:Category")->find($id);
        if ($category==null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($category->getPosition()>1) {
            $p=$category->getPosition();
            $categories=$em->getRepository('AppBundle:Category')->findAll();
            foreach ($categories as $key => $value) {
                if ($value->getPosition()==$p-1) {
                    $value->setPosition($p);  
                }
            }
            $category->setPosition($category->getPosition()-1);
            $em->flush(); 
        }
        return $this->redirect($this->generateUrl('app_category_index'));
    }
    public function downAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $category=$em->getRepository("AppBundle:Category")->find($id);
        if ($category==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $max=0;
        $categories=$em->getRepository('AppBundle:Category')->findBy(array(),array("position"=>"asc"));
        foreach ($categories  as $key => $value) {
            $max=$value->getPosition();  
        }
        if ($category->getPosition()<$max) {
            $p=$category->getPosition();
            foreach ($categories as $key => $value) {
                if ($value->getPosition()==$p+1) {
                    $value->setPosition($p);  
                }
            }
            $category->setPosition($category->getPosition()+1);
            $em->flush();  
        }
        return $this->redirect($this->generateUrl('app_category_index'));
    }
    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $category = $em->getRepository("AppBundle:Category")->find($id);
        if($category==null){
            throw new NotFoundHttpException("Page not found");
        }

        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($category);
            $categories=$em->getRepository('AppBundle:Category')->findBy(array(),array("position"=>"asc"));

            $p=1;
            foreach ($categories as $key => $value) {
                $value->setPosition($p); 
                $p++; 
            }
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_category_index'));
        }
        return $this->render('AppBundle:Category:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $category=$em->getRepository("AppBundle:Category")->find($id);
        if ($category==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new CategoryType(),$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_category_index'));
 
        }
        return $this->render("AppBundle:Category:edit.html.twig",array("category"=>$category,"form"=>$form->createView()));
    }
}
?>