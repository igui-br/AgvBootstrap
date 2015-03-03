<?php
namespace AgvBootstrap\Form\View\Helper;

use Zend\View\Helper\HtmlList;

class FormErrorList extends HtmlList
{

    /**
     * Generates a 'List' element.
     *
     * @param \Zend\Form\Form $form
     *            Array with the elements of the list
     * @param bool $ordered
     *            Specifies ordered/unordered list; default unordered
     * @param array $attribs
     *            Attributes for the ol/ul tag.
     * @param bool $escape
     *            Escape the items.
     * @return string The list XHTML.
     */
    public function __invoke(\Zend\Form\Form $form, $ordered = false, $attribs = false)
    {
        $list = array();
        $this->defineList($form, $list);

        return parent::__invoke($list, $ordered, $attribs, false);
    }

    /**
     * Define Form messages in List
     *
     * @param \Zend\Form\Form|\Zend\Form\Fieldset $form
     */
    protected function defineList($form, &$list)
    {
        foreach ($form as $elementOrFieldset) {
            if ($elementOrFieldset instanceof \Zend\Form\Fieldset) {
                $this->defineList($elementOrFieldset, $list);
            } else {
                if ($elementOrFieldset->getLabel() !== null && count($elementOrFieldset->getMessages()) > 0) {
                    $id = $elementOrFieldset->hasAttribute('id') ? $elementOrFieldset->getAttribute('id') : $elementOrFieldset->getName();
                    $label = $elementOrFieldset->getLabel();

                    $list[] = sprintf('<a href="#%s">%s</a>', $id, $label);
                }
            }
        }
    }
}
