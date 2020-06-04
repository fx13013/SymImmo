<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('surface', IntegerType::class, [
                'label' => 'Surface en m2'
            ])
            ->add('rooms', IntegerType::class, [
                'label' => 'Pièces'
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Chambres'
            ])
            ->add('floor', null, [
                'label' => 'Etages'
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'label' => 'Type de chauffage',
                'choices' => $this->getChoices()
            ])
            ->add('options', EntityType::class, [
                'required' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Ajouter une image',
                'label_attr' => [
                    'data-browse' => 'Parcourir'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('postal_code', null, [
                'label' => 'Code postal'
            ])
            ->add('sold', null, [
                'label' => 'Vendu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = []; 
        foreach($choices as $key => $value){
            $output[$value] = $key;
        }
        return $output;
    }
}
