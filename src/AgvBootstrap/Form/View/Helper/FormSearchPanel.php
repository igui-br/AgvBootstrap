<?php
namespace AgvBootstrap\Form\View\Helper;

class FormSearchPanel extends AbstractHelper
{

    /**
     * Hidden
     *
     * @var boolean
     */
    protected $hidden = false;

    /**
     * From
     *
     * @var \Zend\Form\Form
     */
    protected $form;

    /**
     * Title
     *
     * @var string
     */
    protected $title = 'Search';

    /**
     * Id
     *
     * @var string
     */
    protected $id = 'search';

    /**
     * Class
     *
     * @var string
     */
    protected $class = 'panel-default';

    /**
     * Set Form
     *
     * @param \Zend\Form\Form $form
     * @return \AgvBootstrap\Form\View\Helper\FormSearchPanel
     */
    public function setForm(\Zend\Form\Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getView()->translate($this->title);
    }

    /**
     * Set class
     *
     * @param string $class
     * @return \AgvBootstrap\Form\View\Helper\FormSearchPanel
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    protected function render()
    {
        $view = $this->getView();

        $options = array(
            'indent' => $this->getIndent() . '    ',
            'title_size' => 3,
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'class' => $this->getClass(),
            'hidden' => $this->getHidden(),
            'body' => $view->form($this->getForm())
        );

        return $view->panel($options);
    }
}
