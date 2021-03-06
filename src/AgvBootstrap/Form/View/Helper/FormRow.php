<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormRow as ZendFormRow;
use Zend\Form\Element\Button;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\File;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Radio;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Select;
use Zend\Form\ElementInterface;
use AgvBootstrap\Form\View\Helper\Form as AgvBootstrapForm;

class FormRow extends ZendFormRow
{

    /**
     * The class that is added to element that have errors
     *
     * @var string
     */
    protected $inputErrorClass = 'has-error';

    /**
     * Form Type such as inline and horizontal
     *
     * @var string
     */
    protected $formType = null;

    /**
     * Row class
     *
     * @var string
     */
    protected $rowClass = 'form-group';

    /**
     * Element class
     *
     * @var string
     */
    protected $elementClass = 'form-control';

    /**
     * Invoke helper as functor
     *
     * @param null|ElementInterface $element
     * @param null|string $formType
     * @param null|string $labelPosition
     * @param bool $renderErrors
     * @param string|null $partial
     * @return string FormRow
     */
    public function __invoke(ElementInterface $element = null, $formType = null, $labelPosition = null, $renderErrors = null, $partial = null)
    {
        $this->formType = $formType;

        return parent::__invoke($element, $labelPosition, $renderErrors, $partial);
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param ElementInterface $element
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $elementHelper = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label = $element->getLabel();

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        if ($this->partial) {
            $vars = array(
                'element' => $element,
                'label' => $label,
                'labelAttributes' => $this->labelAttributes,
                'labelPosition' => $this->labelPosition,
                'renderErrors' => $this->renderErrors
            );

            return $this->view->render($this->partial, $vars);
        }

        $elementErrors = '';
        if ($this->renderErrors) {
            $elementErrors = $elementErrorsHelper->render($element);
        }

        if (! $element->hasAttribute('id')) {
            $element->setAttribute('id', $this->getId($element));
        }

        if (isset($label) && '' !== $label) {
            $label = $escapeHtmlHelper($label);
        }

        if ($element instanceof Radio) {
            $rowClass = $this->rowClass;

            $markup = sprintf('<fieldset class="multi-checkbox"><legend class=" ' . $element->getOption('class') . ' ">%s</legend>%s</fieldset>', $label, $elementHelper->render($element));

            $markup = $this->getDivRadioCheckboxHorizontal($markup);
        } elseif ($element instanceof MultiCheckbox) {
            $rowClass = $this->rowClass;
            $element->setLabelAttributes(array(
                'class' => 'checkbox'
            ));

            $markup = sprintf('<fieldset class="multi-radio"><legend class=" ' . $element->getOption('class') . ' ">%s</legend>%s</fieldset>', $label, $elementHelper->render($element));

            $markup = $this->getDivRadioCheckboxHorizontal($markup);
        } elseif ($element instanceof Checkbox) {
            $rowClass = 'checkbox';

            $markup = $labelHelper->openTag($this->getLabelAttributesByElement($element)) . $elementHelper->render($element) . $label . $labelHelper->closeTag();
        } elseif ($element instanceof \Zend\Form\Element\File) {
            $rowClass = $this->rowClass;
            $label = $labelHelper->openTag($this->getLabelAttributesByElement($element)) . $label . $labelHelper->closeTag();
            $markup = $label . $elementHelper->render($element);
        } else if ($element instanceof Hidden) {
            return $elementHelper->render($element);
        } else if ($element instanceof Select) {
            $rowClass = $this->rowClass;
            $elementClass = $element->getAttribute('class');
            if (! empty($elementClass)) {
                $elementClass .= ' ';
            }
            $elementClass .= $this->elementClass;
            $element->setAttribute('class', $elementClass);
            $label = $labelHelper->openTag($this->getLabelAttributesByElement($element)) . $label . $labelHelper->closeTag();
            $markup = $label . $elementHelper->render($element);
        } else if ($element instanceof Submit || $element instanceof Button) {
            $rowClass = $this->rowClass;
            $markup = $elementHelper->render($element);
        } else {
            $rowClass = $this->rowClass;

            $elementClass = $element->getAttribute('class');
            if (! empty($elementClass)) {
                $elementClass .= ' ';
            }
            $elementClass .= $this->elementClass;
            $element->setAttribute('class', $elementClass);

            $label = $labelHelper->openTag($this->getLabelAttributesByElement($element)) . $label . $labelHelper->closeTag();
            $markup = $label . $elementHelper->render($element);
        }

        if ($this->renderErrors) {
            $markup .= $elementErrors;
        }

        $errorClass = $this->getInputErrorClass();

        if (count($element->getMessages()) && ! empty($errorClass)) {
            $rowClass .= ' ' . $errorClass;
        }

        return sprintf('<div class="%s">%s</div> ', $rowClass, $markup);
    }

    /**
     * Return label element
     *
     * @param ElementInterface $element
     * @return string
     */
    protected function getLabelAttributesByElement($element)
    {
        $labelAttributes = $element->getLabelAttributes();

        if (empty($labelAttributes)) {
            $labelAttributes = array();
        }

        if (! isset($labelAttributes['for'])) {
            $labelAttributes['for'] = $element->getAttribute('id');
        }

        if ($this->formType == AgvBootstrapForm::FORM_TYPE_HORIZONTAL) {
            $class = array();
            if (isset($labelAttributes['class']))
                $class = explode(' ', $labelAttributes['class']);

            array_unshift($class, 'control-label');

            if (isset($labelAttributes['grid'])) {
                $size = $labelAttributes['grid'];

                if (is_array($size)) {
                    $class = array_merge($class, $size);
                } elseif (is_int($size)) {
                    $class[] = sprintf('col-lg-%s col-md-%s col-sm-%s col-xs-%s', $size, $size, $size, $size);
                } else {
                    $class[] = $size;
                }
            }

            if (isset($labelAttributes['offset'])) {
                $offset = $labelAttributes['offset'];

                if (is_array($offset)) {
                    $class = array_merge($class, $offset);
                } elseif (is_int($offset)) {
                    $class[] = sprintf('col-lg-offset-%s col-md-offset-%s col-sm-offset-%s col-xs-offset-%s', $offset, $offset, $offset, $offset);
                } else {
                    $class[] = $offset;
                }
            }

            $labelAttributes['class'] = implode(' ', array_unique($class));
        }

        if ($this->formType == AgvBootstrapForm::FORM_TYPE_INLINE) {
            $labelAttributes['class'] = 'sr-only';
        }

        return $labelAttributes;
    }

    /**
     * Return div element for checkbox and radio in horizontal layout
     *
     * @param string $markup
     * @return string
     */
    protected function getDivRadioCheckboxHorizontal($markup)
    {
        if ($this->formType == AgvBootstrapForm::FORM_TYPE_HORIZONTAL) {
            $class = 'col-sm-offset-2 col-sm-10';
            $markup = sprintf('<div class="%s">%s</div> ', $class, $markup);
        }

        return $markup;
    }
}
