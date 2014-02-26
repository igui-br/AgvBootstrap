<?php
namespace AgvBootstrap\View\Helper;

class Tab extends AbstractHelper
{

    /**
     * Default Bootstrap Class Panel
     *
     * @var array
     */
    private $class = array(
        'tabbable'
    );

    /**
     * Tabs
     *
     * @var array
     */
    protected $tab;

    /**
     * Fade Effect
     *
     * @var boolean
     */
    protected $fadeEffect = false;

    /**
     * Style
     *
     * @var string
     */
    protected $style = 'nav-tabs';

    /**
     * Class Tab Pane Item
     *
     * @var array
     */
    private $classTab = array(
        'tab-pane'
    );

    /**
     * Set Class Tab
     *
     * @param string $class
     * @return \AgvBootstrap\View\Helper\Tab
     */
    public function setClass($class = 'tab-default')
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Get Class Tab
     *
     * @return array
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set Tab
     *
     * @param array $tab
     * @return \AgvBootstrap\View\Helper\Tab
     */
    public function setTab(array $tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get Tab
     *
     * @return array
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set Fade Effect
     *
     * @param boolean $bool
     * @return \AgvBootstrap\View\Helper\Tab
     */
    public function setFadeEffect($bool = true)
    {
        $this->fadeEffect = is_bool($bool);

        return $this;
    }

    /**
     * Get Fade Effect
     *
     * @return boolean
     */
    public function getFadeEffect()
    {
        return $this->fadeEffect;
    }

    /**
     * Set Style
     *
     * @param unknown $style
     * @return \AgvBootstrap\View\Helper\Tab
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get Style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set Class Tab Pane Item
     *
     * @param string $classTab
     * @return \AgvBootstrap\View\Helper\Tab
     */
    public function setClassTab($classTab)
    {
        $this->classTab = $classTab;
    }

    /**
     * Get Class Tab Pane Item
     *
     * @param boolean $active
     * @return array
     */
    public function getClassTab($active = false)
    {
        $class = $this->classTab;

        if ($this->getFadeEffect())
            $class[] = 'fade';

        if ($active)
            $class[] = 'active';

        if ($active && $this->getFadeEffect())
            $class[] = 'in';

        return $class;
    }

    /**
     * Reset attributes
     *
     * @return \AgvBootstrap\View\Helper\Tab
     */
    protected function reset()
    {
        $this->class = array('tabbable');
        $this->title = null;
        $this->collapse = 'in';
        $this->indent = null;
        $this->hidden = false;
        $this->background = null;
        $this->id = null;
        $this->classTab = array('tab-pane');
        $this->fadeEffect = false;
        $this->style = 'nav-tabs';
        $this->tab = null;

        return $this;
    }

    protected function render()
    {
        $html = '';

        $html .= $this->getIndent() . '<div class="' . implode(' ', $this->getClass()) . '">' . PHP_EOL;

        // Nav tabs
        $html .= $this->getIndent() . '    <ul class="nav ' . $this->getStyle() . '">' . PHP_EOL;

        $active = true;
        foreach ($this->getTab() as $id => $tab) {
            $html .= $this->getIndent() . '        <li class="' . ($active ? 'active' : '') . '"><a href="#' . $tab['id'] . '" data-toggle="tab">' . $tab['title'] . '</a></li>' . PHP_EOL;
            $active = false;
        }

        $html .= $this->getIndent() . '    </ul>' . PHP_EOL;

        // Tab panes
        $html .= $this->getIndent() . '    <div class="tab-content">' . PHP_EOL;
        $active = true;
        foreach ($this->getTab() as $tab) {
            $html .= $this->getIndent() . '        <div class="' . implode(' ', $this->getClassTab($active)) . '" id="' . $tab['id'] . '">' . $tab['content'] . '</div>' . PHP_EOL;
            $active = false;
        }

        $html .= $this->getIndent() . '    </div>' . PHP_EOL;

        $html .= $this->getIndent() . '</div>' . PHP_EOL;

        return $html;
    }
}
