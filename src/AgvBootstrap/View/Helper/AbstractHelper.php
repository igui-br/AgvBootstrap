<?php
namespace AgvBootstrap\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;

abstract class AbstractHelper extends AbstractHtmlElement
{

    /**
     * Indent
     *
     * @var string
     */
    protected $indent;

    /**
     * Hidden
     *
     * @var boolean
     */
    protected $hidden = true;

    /**
     * Background color
     *
     * @var string
     */
    protected $background = 'bg-light-gray';

    /**
     * Id
     *
     * @var string
     */
    protected $id;

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Configure state
     *
     * @param array $options
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }

        return $this;
    }

    /**
     * Set Indent
     *
     * @param string $indent
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;

        return $this;
    }

    /**
     * Get Indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Set Hidden
     *
     * @param boolean $bool
     * @return \Application\View\Helper\Videos
     */
    public function setHidden($bool = false)
    {
        $this->hidden = is_bool($bool) ? $bool : false;

        return $this;
    }

    /**
     * Get Hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set background
     *
     * @param string $background
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setId($id)
    {
        $this->id = $this->normalizeId($id);

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Invoke Helper
     *
     * @param array $options
     */
    public function __invoke(array $options = null)
    {
        $this->reset();
        if (null != $options)
            $this->setOptions($options);

        return $this->render();
    }

    /**
     * Reset properties object
     */
    abstract protected function reset();

    /**
     * Render HTML
     */
    abstract protected function render();
}
