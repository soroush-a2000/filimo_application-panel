<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',null,array("label"=>"عنوان پکیج"));
        $builder->add('days',null,array("label"=>"مدت زمان (روز)"));
        $builder->add('skukey',null,array("label"=>"کلید SKU"));
        $builder->add('price',null,array("label"=>"قیمت اصلی"));
        $builder->add('priceoff',null,array("label"=>"قیمت با تخفیف"));
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
        return 'Package';
    }
}
?>