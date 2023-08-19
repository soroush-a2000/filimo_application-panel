<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class EditEpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description');

        $builder->add('playas' ,ChoiceType::class, array(
                'choices' => array(
                    1 => "رایگان (بدون ثبت نام)",
                    2 => "ویژه (نیازمند ثبت نام و تهیه اشتراک)",
                    3 => "باز کردن با تماشای ویدئوی تبلیغاتی (نیازمند ثبت نام)"
                )));   
        $builder->add('downloadas' ,ChoiceType::class, array(
                'choices' => array(
                    1 => "رایگان (بدون ثبت نام)",
                    2 => "ویژه (نیازمند ثبت نام و تهیه اشتراک)",
                    3 => "باز کردن با تماشای ویدئوی تبلیغاتی (نیازمند ثبت نام)"
                )));        
        $builder->add('duration');
        $builder->add('enabled');
        $builder->add("file",null,array("label"=>"","required"=>false));
        $builder->add('save', 'submit',array("label"=>"ذخیره"));

    }
    public function getName()
    {
        return 'Episode';
    }
}
?>