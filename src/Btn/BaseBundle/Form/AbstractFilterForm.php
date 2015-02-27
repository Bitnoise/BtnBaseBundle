<?php

namespace Btn\BaseBundle\Form;

use Btn\BaseBundle\Form\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFilterForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'method'          => 'GET',
        ));
    }
}
