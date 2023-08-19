<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('title',null,array("label"=>"عنوان نسخه"));
       $builder->add('features',null,array("label"=>"ویژگی ها ، امکانات و اصلاحات جدید"));
       $builder->add('code',null,array("label"=>"کد نسخه"));
       $builder->add('cleardata',null,array("label"=>"داده های اپلیکیشن پاک شود؟"));
        $builder->add('enabled', 'checkbox', array(
            'label' => 'فعال باشد؟',
            'data' => false,
            "required" => false,
            'attr' => array('checked' => 'checked', 'value' => '1')
        ));
       $builder->add('save', 'submit',array("label"=>"ذخیره"));
    }
    public function getName()
    {
        return 'Version';
    }
}
?>