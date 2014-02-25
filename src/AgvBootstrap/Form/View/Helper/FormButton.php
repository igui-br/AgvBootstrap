<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormButton as ZendFormButton;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;

class FormButton extends ZendFormButton
{

    /**
     * Generate an opening button tag
     *
     * @param  null|array|ElementInterface $attributesOrElement
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<button>';
        }

        if (is_array($attributesOrElement)) {
            $this->getClass($attributesOrElement);
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<button %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $element = $attributesOrElement;
        $name    = $element->getName();
        if (empty($name) && $name !== 0) {
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
            '<button %s>',
            $this->createAttributesString($attributes)
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
