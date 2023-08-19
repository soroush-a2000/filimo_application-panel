<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SlideType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('title', null, array("label" => "عنوان"))
			->add('url', UrlType::class, array("label" => "لینک", "required" => false))
			->add('category')
			->add('genre')
			->add('channel')
			->add('poster')
			->add('type', ChoiceType::class, array(
				'choices' => array(
					5 => "ژانر",
					4 => "فیلم یا سریال",
					3 => "کانال",
					2 => "دسته بندی کانال",
					1 => "باز کردن لینک",
				)))
			->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
				$article = $event->getData();
				$form = $event->getForm();
				if ($article and null !== $article->getId()) {
					$form->add("file", null, array("label" => "", "required" => false));
				} else {
					$form->add("file", null, array("label" => "", "required" => true));
				}
			});
		$builder->add('save', 'submit', array("label" => "ذخیره"));
	}
	public function getName() {
		return 'Slide';
	}
}
?>