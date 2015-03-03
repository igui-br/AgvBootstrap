<?php
namespace AgvBootstrap\View\Helper;

class Callout extends AbstractHelper
{

    /**
     * Default Bootstrap Class Callout
     *
     * @var array
     */
    private $class = array(
        'callout'
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
     * Callout Body
     *
     * @var string
     */
    protected $body;

    /**
     * Set Class Callout
     *
     * @param string $class
     * @return \AgvBootstrap\View\Helper\Callout
     */
    public function setClass($class = 'callout-default')
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Get Class Callout
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
            throw new \InvalidArgumentException('Callout size heading invalid!');

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
     * @return \AgvBootstrap\View\Helper\Callout
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
        $this->class = array('callout');
        $this->titleSize = 4;
        $this->title = null;
        $this->body = null;
        $this->indent = null;
        $this->hidden = false;

        return $this;
    }

    protected function render()
    {
        $html = '';

        if ($this->getHidden())
            $this->class[] = 'hidden-xs';

        $id = uniqid('callout-');

        $html .= $this->getIndent() . '<div class="' . implode(' ', $this->getClass()) . '" id="' . $id . '">' . PHP_EOL;
        $html .= $this->getIndent() . '    <' . $this->getTitleSize() . '>' . $this->getTitle() . '</' . $this->getTitleSize() . '>' . PHP_EOL;

        $html .= $this->getBody();

        $html .= $this->getIndent() . '</div>' . PHP_EOL;

        return $html;
    }
}
