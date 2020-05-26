<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('surface', null, [
                'label' => 'Surface en m2'
            ])
            ->add('rooms', null, [
                'label' => 'Pièces'
            ])
            ->add('bedrooms', null, [
                'label' => 'Chambres'
            ])
            ->add('floor', null, [
                'label' => 'Etages'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'label' => 'Type de chauffage',
                'choices' => $this->getChoices()
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address', null, [
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
