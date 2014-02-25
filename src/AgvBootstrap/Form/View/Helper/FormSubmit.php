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

        $class = array();

        if ($element->hasAttribute('grid')) {
            $grid = $element->getAttribute('grid');

            if (is_array($grid)) {
                $class = array_merge($class, $grid);
            } elseif (is_int($grid)) {
                $class[] = sprintf('col-lg-%s col-md-%s col-sm-%s col-xs-%s', $grid, $grid, $grid, $grid);
            } else {
                $class[] = $grid;
            }
        }

        if ($element->hasAttribute('offset')) {
            $offset = $element->getAttribute('offset');

            if (is_array($offset)) {
                $class = array_merge($class, $offset);
            } elseif (is_int($offset)) {
                $class[] = sprintf('col-lg-offset-%s col-md-offset-%s col-sm-offset-%s col-xs-offset-%s', $offset, $offset, $offset, $offset);
            } else {
                $class[] = $offset;
            }
        }

        $class = implode(' ', array_unique($class));

        return sprintf(
            '<div class="%s"><input %s%s</div>' . PHP_EOL,
            $class,
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
