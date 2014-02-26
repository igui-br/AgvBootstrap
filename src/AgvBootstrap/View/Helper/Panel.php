<?php
namespace AgvBootstrap\View\Helper;

class Panel extends AbstractHelper
{

    /**
     * Default Bootstrap Class Panel
     *
     * @var array
     */
    private $class = array(
        'panel'
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
     * Panel Body
     *
     * @var string
     */
    protected $body;

    /**
     * Set Class Panel
     *
     * @param string $class
     * @return \AgvBootstrap\View\Helper\Panel
     */
    public function setClass($class = 'panel-default')
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Get Class Panel
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
            throw new \InvalidArgumentException('Panel size heading invalid!');

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
     * @return \AgvBootstrap\View\Helper\Panel
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
     * Reset attributes
     *
     * @return \AgvBootstrap\View\Helper\Panel
     */
    protected function reset()
    {
        $this->class = array('panel');
        $this->titleSize = null;
        $this->body = null;
        $this->title = null;
        $this->indent = null;
        $this->hidden = false;
        $this->background = null;
        $this->id = null;

        return $this;
    }

    protected function render()
    {
        $html = '';

        if ($this->getHidden())
            $this->class[] = 'hidden-xs';

        $html .= $this->getIndent() . '<div class="' . implode(' ', $this->getClass()) . '">' . PHP_EOL;
        $html .= $this->getIndent() . '    <div class="panel-heading">' . PHP_EOL;
        $html .= $this->getIndent() . '        <' . $this->getTitleSize() . ' class="panel-title">' . $this->getTitle() . '</' . $this->getTitleSize() . '>' . PHP_EOL;
        $html .= $this->getIndent() . '    </div>' . PHP_EOL;

        $html .= $this->getIndent() . '    <div class="panel-body">' . PHP_EOL;

        $html .= $this->getBody();

        $html .= $this->getIndent() . '    </div>' . PHP_EOL;
        $html .= $this->getIndent() . '</div>' . PHP_EOL;

        return $html;
    }
}
