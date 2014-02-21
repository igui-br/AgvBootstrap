<?php
namespace AgvBootstrap\View\Helper;

class Portlet extends AbstractHelper
{

    /**
     * Default Bootstrap Class Portlet
     *
     * @var array
     */
    private $class = array(
        'portlet'
    );

    /**
     * HTML HEAD Sizes
     *
     * @var array
     */
    private $headings = array(
        1 => 'h1',
        2 => 'h2',
        3 => 'h3',
        4 => 'h4',
        5 => 'h5',
        6 => 'h6'
    );

    /**
     * Title Size
     *
     * @var string
     */
    protected $titleSize;

    /**
     * Portlet Body
     *
     * @var string
     */
    protected $body;

    /**
     * Portlet Footer
     *
     * @var unknown
     */
    protected $footer;

    /**
     * Set Class Portlet
     *
     * @param string $class
     * @return \AgvBootstrap\View\Helper\Portlet
     */
    public function setClass($class = 'portlet-default')
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Get Class Portlet
     *
     * @return array
     */
    public function getClass()
    {
        return $this->class;
    }

    public function setTitleSize($size)
    {
        if (is_int($size) && ($size >= 1 || $size <= 6))
            $this->titleSize = $size;
        elseif (is_string($size) && in_array($size, $this->headings))
            $this->titleSize = array_search($size, $this->headings);
        else
            throw new \InvalidArgumentException('Portlet size heading invalid!');

        return $this;
    }

    public function getTitleSize()
    {
        return $this->headings[$this->titleSize];
    }

    /**
     * Set Body
     *
     * @param string $body
     * @return \AgvBootstrap\View\Helper\Portlet
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get Body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set Footer
     *
     * @param string $footer
     * @return \AgvBootstrap\View\Helper\Portlet
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get Footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    protected function render()
    {
        $html = '';

        if ($this->getHidden())
            $this->class[] = 'hidden-xs';

        $id = uniqid('portlet-');

        $html .= $this->getIndent() . '<div class="' . implode(' ', $this->getClass()) . '">' . PHP_EOL;
        $html .= $this->getIndent() . '    <div class="portlet-heading">' . PHP_EOL;
        $html .= $this->getIndent() . '        <div class="portlet-title">' . PHP_EOL;
        $html .= $this->getIndent() . '            <' . $this->getTitleSize() . '>' . $this->getTitle() . '</' . $this->getTitleSize() . '>' . PHP_EOL;
        $html .= $this->getIndent() . '        </div>' . PHP_EOL;
        $html .= $this->getIndent() . '        <div class="portlet-widgets">' . PHP_EOL;
        $html .= $this->getIndent() . '            <a href="#' . $id . '" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>' . PHP_EOL;
        $html .= $this->getIndent() . '        </div>' . PHP_EOL;
        $html .= $this->getIndent() . '        <div class="clearfix"></div>' . PHP_EOL;
        $html .= $this->getIndent() . '    </div>' . PHP_EOL;

        $html .= $this->getIndent() . '    <div class="panel-collapse in" id="' . $id . '">' . PHP_EOL;

        $html .= $this->getIndent() . '        <div class="portlet-body">' . PHP_EOL;
        $html .= $this->getBody();
        $html .= $this->getIndent() . '        </div>' . PHP_EOL;

        $html .= $this->getIndent() . '    </div>' . PHP_EOL;

        if (null != $this->getFooter()) {
            $html .= $this->getIndent() . '    <div class="portlet-footer">' . PHP_EOL;
            $html .= $this->getFotter();
            $html .= $this->getIndent() . '    </div>' . PHP_EOL;
        }

        $html .= $this->getIndent() . '</div>' . PHP_EOL;

        return $html;
    }
}
