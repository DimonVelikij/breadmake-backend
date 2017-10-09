<?php

namespace Bread\ContentBundle\Form\Type;

use Bread\ContentBundle\ImageCropService\ImageCrop;
use Bread\ContentBundle\ImageCropService\Entity\ImageCropEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageCropType extends AbstractType
{
    /** @var  ImageCrop */
    private $imageCrop;

    /**
     * ImageCropType constructor.
     * @param ImageCrop $imageCrop
     */
    public function __construct(ImageCrop $imageCrop)
    {
        $this->imageCrop = $imageCrop;
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var ImageCropEntity $cropEntity */
        $imageCropEntity = $this->imageCrop->getEntity($options['entity']);

        $view->vars['entity'] = $options['entity'];
        $view->vars['image_crop_width'] = $imageCropEntity->getCropSize()->getWidth();
        $view->vars['image_crop_height'] = $imageCropEntity->getCropSize()->getHeight();
        $view->vars['object'] = $form->getParent()->getViewData();
        $view->vars['multiple'] = $options['multiple'];

        if ($options['multiple']) {
            $view->vars['images'] = $form->getParent()->getViewData()->getImages();
            $view->vars['sonata_help'] = $this->imageCrop->getMultipleFormHelp($options['entity']);
        } else {
            $view->vars['image'] = $form->getParent()->getViewData()->getImage();
            $view->vars['sonata_help'] = $this->imageCrop->getFormHelp($options['entity']);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'entity'        =>  null,
            'data_class'    =>  null
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'image_crop';
    }

    /**
     * @return FileType
     */
    public function getParent()
    {
        return FileType::class;
    }
}