<?php
namespace AgvBootstrap\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SocialSignInButton extends AbstractHelper
{

    /**
     * Class button
     *
     * @var array
     */
    protected $class = array('btn');

    /**
     * Label
     *
     * @var string
     */
    protected $label;

    /**
     * Set Class
     *
     * @param array $class
     * @return \AgvBootstrap\View\Helper\SocialSignInButton
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Add Class Item
     *
     * @param string $class
     * @return \AgvBootstrap\View\Helper\SocialSignInButton
     */
    public function addClass($class)
    {
        $this->class[] = $class;

        return $this;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return \AgvBootstrap\View\Helper\SocialSignInButton
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Invoke class
     *
     * @param string $provider
     * @param string $redirect
     */
    public function __invoke($provider = null, $redirect = false)
    {
        if (null == $provider)
            return $this;

        $redirectArg = $redirect ? '?redirect=' . $redirect : '';
        $label = $this->label == null ? ucfirst($provider) : $this->label;

        echo
            '<a class="' . implode(' ', $this->class) . '" href="'
            . $this->view->url('scn-social-auth-user/login/provider', array('provider' => $provider))
            . $redirectArg . '">' . $label . '</a>';
    }
}
