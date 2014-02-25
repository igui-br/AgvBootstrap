<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormSubmit as ZendFormSubmit;
use Zend\Form\ElementInterface;

class FormSubmit extends ZendFormSubmit
{

    /**
     * Render a form <input> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $name = $element->getName();
        if ($name === null || $name === '') {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes          = $element->getAttributes();
        $attributes['name']  = $name;
        $attributes['type']  = $this->getType($element);
        $attributes['value'] = $element->getValue();

        $this->getClass($attributes);

        return sprintf(
            '<input %s%s',
            $this->createAttributesString($attributes),
            $this->getInlineClosingBracket()
        );
    }

    public function getClass(&$attributes)
    {
        $class = (key_exists('class', $attributes) ? $attributes['class'] : null);
        if (!empty($class)) {
            $class = explode(' ', $class);
            array_unshift($class, 'btn', 'btn-default');

            $attributes['class'] = implode(' ', array_unique($class));
        } else {
            $attributes['class'] = 'btn btn-default';
        }
    }
}
