<?php

namespace Btn\BaseBundle\Twig;

class HtmlExtension extends \Twig_Extension
{
    /**
     *
     */
    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('btn_html', array($this, 'isHtml')),
        );
    }

    public function isHtml($input)
    {
        if (!is_string($input)) {
            return;
        }

        return preg_match('~^<[^>]+>~', $input) ? true : false;
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_base.extension.translation';
    }
}
