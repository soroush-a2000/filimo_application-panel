<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Form\FormEvents;
class ChannelEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title');
        $builder->add('description');
        $builder->add('featured');
        $builder->add('enabled');
        $builder->add('comment');
        $builder->add('classification');
        $builder->add('website');
        $builder->add('tags');
        $builder->add('playas' ,ChoiceType::class, array(
                'choices' => array(
                    1 => "رایگان (بدون ثبت نام)",
                    2 => "ویژه (نیازمند ثبت نام و تهیه اشتراک)",
                    3 => "باز کردن با تماشای ویدئوی تبلیغاتی (نیازمند ثبت نام)"
                )));   
        $builder->add("categories",'entity',
                  array(
                        'class' => 'AppBundle:Category',
                        'expanded' => true,
                        "multiple" => "true",
                        'by_reference' => false
                      )
                  );

        $builder->add('country',
            'entity',
            array(
                'class' => 'AppBundle:Country',
                'property' => 'title',
                'placeholder' => '--- انتخاب کشور ---',
                "required" => false,
                'query_builder' => function (\AppBundle\Repository\CountryRepository $repository) {
                    return $repository->createQueryBuilder('c')->add('orderBy', 'c.title ASC');
                }
            )
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $article = $event->getData();
            $form = $event->getForm();
            if ($article and null !== $article->getId()) {
                 $form->add("file",null,array("label"=>"","required"=>false));
            }else{
                 $form->add("file",null,array("label"=>"","required"=>true));
            }
        });
        $builder->add('save', 'submit',array("label"=>"ذخیره"));

    }
    public function getName()
    {
        return 'Channel';
    }
}
?>