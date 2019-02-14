<?php

namespace CJ\IMayFlyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($builder->getData()->getId() === null ){
            $builder->add('uploadedFile',FileType::class);
        }


        $builder
            ->add('title',TextType::class)
            ->add('tags',TextareaType::class)
            ->add('category',ChoiceType::class,[
                'choices'  => [
                    'Screenshot'=> 'Screenshot',
                    'Dessin' => 'Dessin',
                    'Autre' => 'Autre',
                ],])
            ->add('description')
            ->add('save',SubmitType::class)
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CJ\IMayFlyBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cj_imayflybundle_post';
    }


}
