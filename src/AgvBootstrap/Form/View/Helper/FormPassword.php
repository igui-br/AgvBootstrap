<?php

namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormInput as ZendFormInput;
use Zend\Form\ElementInterface;

class FormPassword extends ZendFormInput
{
    /**
     * Attributes valid for the input tag type="password"
     *
     * @var array
     */
    protected $validTagAttributes = array(
        'name'           => true,
        'autocomplete'   => true,
        'autofocus'      => true,
        'disabled'       => true,
        'form'           => true,
        'maxlength'      => true,
        'pattern'        => true,
        'placeholder'    => true,
        'readonly'       => true,
        'required'       => true,
        'size'           => true,
        'type'           => true,
        'value'          => true,
    );

    /**
     * Determine input type to use
     *
     * @param  ElementInterface $element
     * @return string
     */
    protected function getType(ElementInterface $element)
    {
        return 'password';
    }
}