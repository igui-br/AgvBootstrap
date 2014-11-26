<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormSelect as ZendFormSelect;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Select as SelectElement;
use Zend\Form\Exception;
use Zend\Stdlib\ArrayUtils;

class FormSelect extends ZendFormSelect
{
    /**
     * Render a form <select> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        if (!$element instanceof SelectElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Zend\Form\Element\Select',
                __METHOD__
            ));
        }

        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $options = $element->getValueOptions();

        if (($emptyOption = $element->getEmptyOption()) !== null) {
            $options = array('' => $emptyOption) + $options;
        }

        $attributes = $element->getAttributes();
        $value      = $this->validateMultiValue($element->getValue(), $attributes);

        if (! isset($attributes['id']))
            $attributes['id'] = $name;

        $attributes['name'] = $name;
        if (array_key_exists('multiple', $attributes) && $attributes['multiple']) {
            $attributes['name'] .= '[]';
        }
        $this->validTagAttributes = $this->validSelectAttributes;

        if (! $element->hasAttribute('grid') && ! $element->hasAttribute('offset')) {
            return sprintf(
                '<select %s>%s</select>',
                $this->createAttributesString($attributes),
                $this->renderOptions($options, $value)
            );
        }

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
            $offset = $labelAttributes['offset'];

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
            '<div class="%s"><select %s>%s</select></div>' . PHP_EOL,
            $class,
            $this->createAttributesString($attributes),
            $this->renderOptions($options, $value)
        );
    }


    public function getClass(&$attributes)
    {
        $class = (key_exists('class', $attributes) ? $attributes['class'] : null);
        if (!empty($class)) {
            $class = explode(' ', $class);
            array_unshift($class, 'form-control');

            $attributes['class'] = implode(' ', array_unique($class));
        } else {
            $attributes['class'] = 'form-control';
        }
    }
}
