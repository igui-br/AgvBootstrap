<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\Form as ZendForm;
use Zend\Form\FormInterface;

/**
 * Description of Form
 *
 * @author alberto
 */
class Form extends ZendForm
{

    /**
     * Form type Horizontal
     *
     * @var string
     */
    const FORM_TYPE_HORIZONTAL = 'horizontal';

    /**
     * Form type Inline
     *
     * @var string
     */
    const FORM_TYPE_INLINE = 'inline';

    /**
     * Attributes valid for this tag (form)
     *
     * @var array
     */
    protected $validTagAttributes = array(
        'accept-charset' => true,
        'action' => true,
        'autocomplete' => true,
        'enctype' => true,
        'method' => true,
        'name' => true,
        'novalidate' => true,
        'target' => true,
        'role' => true,
        'class' => true
    );

    /**
     * Valid Types
     *
     * @var array
     */
    protected $validTypes = array(
        'inline' => true,
        'horizontal' => true
    );

    /**
     * Type
     *
     * @var string
     */
    protected $type = null;

    /**
     * Invoke as function
     *
     * @param null|FormInterface $form
     * @return Form
     */
    public function __invoke(FormInterface $form = null, $formType = null)
    {
        $this->setType($formType);
        if (null != $form && null == $formType) {
            $class = $form->getAttribute('class');
            if (preg_match('/inline/i', $class))
                $this->setType('inline');

            if (preg_match('/horizontal/i', $class))
                $this->setType('horizontal');
        }

        return parent::__invoke($form);
    }

    /**
     * Render a form from the provided $form,
     *
     * @param FormInterface $form
     * @return string
     */
    public function render(FormInterface $form)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';

        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent .= $this->getView()->formCollection($element);
            } else {
                $formContent .= $this->getView()->formRow($element, $this->type);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     *
     * @param FormInterface $form
     * @return string
     */
    public function openTag(FormInterface $form = null)
    {
        $attributes = array(
            'action' => '',
            'method' => 'get',
            'role' => 'form',
            'class' => ''
        );

        if ($form instanceof FormInterface) {
            $formAttributes = $form->getAttributes();
            if (! array_key_exists('id', $formAttributes) && array_key_exists('name', $formAttributes)) {
                $formAttributes['id'] = $formAttributes['name'];
            }
            $attributes = array_merge($attributes, $formAttributes);
        }

        if (! empty($this->type) && ! empty($this->validTypes[$this->type])) {
            if (isset($attributes['class'])) {
                $attributes['class'] = $attributes['class'] . ' ';
            }

            $attributes['class'] .= 'form-' . $this->type;
        }

        $tag = sprintf('<form %s>', $this->createAttributesString($attributes));

        return $tag;
    }

    /**
     * Set Type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
