<?php

namespace Btn\BaseBundle\Form;

use Btn\BaseBundle\Util\Form;

class FormRegistry
{
    private $types = array();

    public function addType($alias, $class)
    {
        $this->types[$alias] = $class;
    }

    public function hasType($alias)
    {
        return array_key_exists($alias, $this->types);
    }

    public function getType($alias)
    {
        $class = $this->types[$alias];

        return Form::getFormName(array(
            'alias' => $alias,
            'class' => $class,
        ));
    }
}
