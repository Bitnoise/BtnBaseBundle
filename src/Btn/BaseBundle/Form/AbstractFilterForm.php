<?php

namespace Btn\BaseBundle\Form;

use Btn\BaseBundle\Form\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFilterForm extends AbstractType
{
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'method'          => 'GET',
        ));
    }
}
