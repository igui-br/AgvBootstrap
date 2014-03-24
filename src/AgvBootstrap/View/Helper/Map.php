<?php
namespace AgvBootstrap\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Map extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     *
     * @var decimal
     */
    private $longcenter;

    /**
     *
     * @var decimal
     */
    private $latcenter;

    /**
     *
     * @var Zend\ServiceManager\ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     *
     * @var boolean
     */
    private $sensor = 'false';

    /**
     * Class
     *
     * @var array
     */
    private $class = array();

    /**
     *
     * @var integer
     */
    private $zoom = 7;

    /**
     *
     * @var string $key
     */
    private $key;

    /**
     * Altura 250px
     *
     * @var string
     */
    private $height = "250px";

    /**
     * Largura 370px
     *
     * @var string
     */
    private $width = "370px";

    /**
     *
     * @var string
     */
    private $animation = '';

    /**
     *
     * @var string
     */
    private $icon = null;

    /**
     *
     * @var string
     */
    protected $title = '';

    /**
     *
     * @var string
     */
    private $region = 'BR';

    /**
     *
     * @var string
     */
    private $country = 'Brasil';

    /**
     *
     * @var boolean
     */
    private $draggable = 'false';

	/**
	/* (non-PHPdoc)
	 * @see \AgvBootstrap\View\Helper\AbstractHelper::__invoke()
	 */
	public function __invoke(array $options = null)
	{
		$sm = $this->getServiceLocator()->getServiceLocator();
		$config = $sm->get('config');
		$this->key         = $config['Map']['key'];
		$this->latcenter   = $config['Map']['latecenter'];
		$this->longcenter = $config['Map']['longcenter'];
		$this->zoom        = $config['Map']['zoom'];

		$this->reset();
		if (null != $options)
		    $this->setOptions($options);

		return $this->render();
	}

	/**
	 * (non-PHPdoc)
	 * @see \AgvBootstrap\View\Helper\Map
	 */
    protected function reset()
    {
        $remote = new \Zend\Http\PhpEnvironment\RemoteAddress();
        $validator = new \Zend\Validator\Ip();

        $this->animation = '';
        $this->class     = array();
        $this->country   = 'Brasil';
        $this->height    = '250px';
        $this->icon      = null;
        $this->region    = 'BR';
        $this->sensor    = 'false';
        $this->width     = '350px';
        $this->title     = 'Igui Piscinas';
        $this->zoom      = 7;
        $this->draggable = 'false';

        if ($this->getView()->geoip($remote->getIpAddress())->getLongitude()) {
            $this->longcenter = $this->getView()->geoip($remote->getIpAddress())->getLongitude();
            $this->latcenter = $this->getView()->geoip($remote->getIpAddress())->getLatitude();
        } else {
            $this->longcenter = '-53.44846132812495';
            $this->latcenter = '-10.293316376424693';
        }

        return $this;
    }

	/* (non-PHPdoc)
     * @see \AgvBootstrap\View\Helper\AbstractHelper::render()
     */
    protected function render()
    {
        $html  = '';
        $html .= $this->getIndent() . '<fieldset>' . PHP_EOL;
        $html .= $this->getIndent() . '<div class="campo ' . implode(' ', $this->getClass()) . '">' . PHP_EOL;
        $html .= $this->getIndent() . '<label for="txtEndereco">Endereço:</label>' . PHP_EOL;
        $html .= $this->getIndent() . '<input type="text" id="txtEndereco" name="txtEndereco" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"/>' . PHP_EOL;
        $html .= $this->getIndent() . '<input type="button" id="btnEndereco" name="btnEndereco" value="Mostrar no mapa" />' . PHP_EOL;
        $html .= $this->getIndent() . '<div id="mapa" style="height: '.$this->height.'; width: '.$this->width.'">' . PHP_EOL;
        $html .= $this->getIndent() . '</div>' . PHP_EOL;
        $html .= $this->getIndent() . '</div>' . PHP_EOL;
        $html .= $this->getIndent() . '</fieldset>' . PHP_EOL;

        $html .= $this->getIndent() . '<ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 1; top: 0px; left: 0px; display: none;"> </ul>' . PHP_EOL;

        $html .= $this->getIndent() . '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key='.$this->key.'&sensor='.$this->sensor.'"></script>' . PHP_EOL;

        $html .= $this->getIndent() . '<script type="text/javascript">' . PHP_EOL;

        $html .= $this->getIndent() . 'var geocoder;' . PHP_EOL;
        $html .= $this->getIndent() . 'var map;' . PHP_EOL;
        $html .= $this->getIndent() . 'var marker;' . PHP_EOL;
        $html .= $this->getIndent() . 'function initialize() {' . PHP_EOL;
        $html .= $this->getIndent() . 'var latlng = new google.maps.LatLng('.$this->latcenter.', '.$this->longcenter.');' . PHP_EOL;
        $html .= $this->getIndent() . 'var options = {' . PHP_EOL;
        $html .= $this->getIndent() . 'zoom:'.$this->zoom . ',' . PHP_EOL;
        $html .= $this->getIndent() . 'center: latlng,' . PHP_EOL;
        $html .= $this->getIndent() . 'mapTypeId: google.maps.MapTypeId.ROADMAP' . PHP_EOL;
        $html .= $this->getIndent() . '};' . PHP_EOL;
        $html .= $this->getIndent() . 'map = new google.maps.Map(document.getElementById("mapa"), options);' . PHP_EOL;
        $html .= $this->getIndent() . 'geocoder = new google.maps.Geocoder();' . PHP_EOL;
        $html .= $this->getIndent() . 'marker = new google.maps.Marker({' . PHP_EOL;
        $html .= $this->getIndent() . 'title: "'.$this->title.'",' . PHP_EOL;
        $html .= $this->getIndent() . 'map: map,' . PHP_EOL;

        if ($this->icon)
            $html .= $this->getIndent() . 'icon: ' .$this->icon. ',' . PHP_EOL;

        $html .= $this->getIndent() . 'draggable: ' . $this->draggable . ',' . PHP_EOL;
        $html .= $this->getIndent() . '});' . PHP_EOL;
        $html .= $this->getIndent() . 'marker.setPosition(latlng);' . PHP_EOL;
        $html .= $this->getIndent() . '}' . PHP_EOL;

        $html .= $this->getIndent() . 'initialize();' . PHP_EOL;

        $html .= $this->getIndent() . 'google.maps.event.addListener(marker, "drag", function () {' . PHP_EOL;
        $html .= $this->getIndent() . 'geocoder.geocode({ "latLng": marker.getPosition() }, function (results, status) {' . PHP_EOL;
        $html .= $this->getIndent() . 'if (status == google.maps.GeocoderStatus.OK) {' . PHP_EOL;
        $html .= $this->getIndent() . 'if (results[0]) {' . PHP_EOL;
        $html .= $this->getIndent() . '$("#txtEndereco").val(results[0].formatted_address);' . PHP_EOL;
        $html .= $this->getIndent() . '$("#latidude").val(marker.getPosition().lat());' . PHP_EOL;
        $html .= $this->getIndent() . '$("#longitude").val(marker.getPosition().lng());' . PHP_EOL;
        $html .= $this->getIndent() . '}}});});' . PHP_EOL;

        $html .= $this->getIndent() . 'function carregarNoMapa(endereco) {' . PHP_EOL;
        $html .= $this->getIndent() . 'geocoder.geocode({ "address": endereco + ", '.$this->country.'", "region": "'.$this->region.'" }, function (results, status) {' . PHP_EOL;
        $html .= $this->getIndent() . 'if (status == google.maps.GeocoderStatus.OK) {' . PHP_EOL;
        $html .= $this->getIndent() . 'if (results[0]) {' . PHP_EOL;
        $html .= $this->getIndent() . 'var latitude = results[0].geometry.location.lat();' . PHP_EOL;
        $html .= $this->getIndent() . 'var longitude = results[0].geometry.location.lng();' . PHP_EOL;
        $html .= $this->getIndent() . '$("#txtEndereco").val(results[0].formatted_address);' . PHP_EOL;
        $html .= $this->getIndent() . '$("#latitude").val(latitude);' . PHP_EOL;
        $html .= $this->getIndent() . 'var location = new google.maps.LatLng(latitude, longitude);' . PHP_EOL;
        $html .= $this->getIndent() . 'marker.setPosition(location);' . PHP_EOL;
        $html .= $this->getIndent() . '$("#longitude").val(longitude);' . PHP_EOL;
        $html .= $this->getIndent() . 'map.setCenter(location);' . PHP_EOL;
        $html .= $this->getIndent() . 'PHP_EOL;map.setZoom(12);' . PHP_EOL;
        $html .= $this->getIndent() . '}}});}' . PHP_EOL;

        $html .= $this->getIndent() . '</script>' . PHP_EOL;

        $this->getView()->inlineScript()->appendFile($this->getView()->basePath() . '/js/mapa.js');

        return $html;

    }

    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     *
     * @return decimal
     */
    public function getLongcenter()
    {
        return $this->longcenter;
    }

    /**
     *
     * @param decimal $longcenter
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setLongcenter($longcenter)
    {
        $this->longcenter = $longcenter;
        return $this;
    }

    /**
     *
     * @return decimal
     */
    public function getLatcenter()
    {
        return $this->latcenter;
    }

    /**
     *
     * @param decimal $latcenter
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setLatcenter($latcenter)
    {
        $this->latcenter = $latcenter;
        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     *
     * @param boolean $sensor
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     *
     * @param array $class
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setClass(array $class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     *
     * @param integer $zoom
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     *
     * @param string $key
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     *
     * @param string $height
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     *
     * @param string $width
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAnimation()
    {
        return $this->animation;
    }

    /**
     *
     * @param string $animation
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setAnimation($animation)
    {
        $this->animation = $animation;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     *
     * @param string $icon
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     *
     * @param string $region
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param string $country
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function getDraggable()
    {
        return $this->draggable;
    }

    /**
     *
     * @param boolean $draggable
     * @return \AgvBootstrap\View\Helper\Map
     */
    public function setDraggable($draggable)
    {
        $this->draggable = $draggable;
        return $this;
    }




}