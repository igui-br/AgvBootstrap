<?php
namespace AgvBootstrap\View\Helper;

/**
 * Description of Tile Button
 *
 * @author victor.guedes
 */
class TileButton extends AbstractHelper
{

    /**
     * Route
     *
     * @var string
     */
    protected $route;

    /**
     * Url
     *
     * @var string
     */
    protected $url = '#';

    /**
     * Target
     *
     * @var string
     */
    protected $target;

    /**
     * Value
     *
     * @var int
     */
    protected $value;

    /**
     * Icon
     *
     * @var string
     */
    protected $icon;

    /**
     * Refresh
     *
     * @var boolean
     */
    protected $refresh;

    /**
     * Set Route
     *
     * @param string $route
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get Route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set Url
     *
     * @param string $url
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get Url
     *
     * @return string
     */
    public function getUrl()
    {
        if (null != $this->getRoute())
            return  $this->getView()->url($this->getRoute());

        return $this->url;
    }

    /**
     * Set Target
     *
     * @param string $target
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get Target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set title
     *
     * @param string $value
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return \AgvBootstrap\View\Helper\TileButton
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set refresh
     *
     * @param boolean $refresh
     * @return \Application\View\Helper\Videos
     */
    public function setRefresh($refresh = false)
    {
        if (is_bool($refresh))
            $this->refresh = $refresh;

        return $this;
    }

    /**
     * Get refresh
     *
     * @return boolean
     */
    public function getRefresh()
    {
        return $this->refresh;
    }

    /**
     * Reset attributes
     *
     * @return \AgvBootstrap\View\Helper\Tab
     */
    protected function reset()
    {
        $this->background = 'bg-light-gray';
        $this->hidden = false;
        $this->icon = null;
        $this->id = null;
        $this->indent = null;
        $this->refresh = false;
        $this->route = null;
        $this->target = null;
        $this->title = null;
        $this->url = '#';
        $this->value = null;

        return $this;
    }

    protected function render()
    {
        $html = '';

        $attribs = array(
            'href' => $this->getUrl(),
            'id' => $this->getId(),
            'class' => 'panel-stat3 ' . $this->getBackground() . (null == $this->getValue() ? ' no-value' : '') . ($this->getHidden() ? ' hidden-xs' : '')
        );

        if (null != $this->getTarget())
            $attribs['target'] = $this->getTarget();

        $html .= $this->getIndent() . '<a ' . $this->htmlAttribs($attribs) . '>' . PHP_EOL;

        if (null != $this->getValue())
            $html .= $this->getIndent() . '    <h2 class="value m-top-none">' . $this->getValue() . '</h2>' . PHP_EOL;

        $html .= $this->getIndent() . '    <h4>' . $this->getTitle() . '</h4>' . PHP_EOL;

        if (null != $this->getIcon()) {
            $html .= $this->getIndent() . '    <div class="stat-icon">' . PHP_EOL;
            $html .= $this->getIndent() . '        <span class="' . $this->getIcon() . '"></span>' . PHP_EOL;
            $html .= $this->getIndent() . '    </div>' . PHP_EOL;
        }

        if ($this->getRefresh()) {
            $html .= $this->getIndent() . '    <div class="refresh-button">' . PHP_EOL;
            $html .= $this->getIndent() . '        <span class="fa fa-refresh"></span>' . PHP_EOL;
            $html .= $this->getIndent() . '    </div>' . PHP_EOL;
            $html .= $this->getIndent() . '    <div class="loading-overlay">' . PHP_EOL;
            $html .= $this->getIndent() . '        <span class="loading-icon fa fa-refresh fa-spin fa-lg"></span>' . PHP_EOL;
            $html .= $this->getIndent() . '    </div>' . PHP_EOL;
        }

        $html .= $this->getIndent() . '</a>' . PHP_EOL;

        return $html;
    }
}
