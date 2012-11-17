<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_View
 */



namespace HMAjaxStrategy\View\Strategy;

use Zend\Mvc\MvcEvent;

use Zend\View\Renderer\RendererInterface;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

/**
 * @category   Zend
 * @package    Zend_View
 * @subpackage Strategy
 */
class AjaxStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var RendererInterface
     */
    protected $renderer;
    
    protected $ajaxRenderer;

    /**
     * Constructor
     *
     * @param  JsonRenderer $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;   
    }

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
	public function attach(EventManagerInterface $events, $priority = 1)
    {
//     	$this->listeners[] = $events->getSharedManager()->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH, array($this, 'setTerminal'), -10100);
    	$this->listeners[] = $events->getSharedManager()->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($this, 'setTerminal'), -90);
    	//$this->listeners[] = $events->getSharedManager()->attach('Zend\Mvc\Application', 'dispatch', array($this, 'setTerminal'),-50);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }
    
    public function setTerminal(MvcEvent $e)
    {
    	$model = $e->getResult();
    	$request = $e->getRequest();
    	if($request->isXmlHttpRequest())
    	{
    		$model->setTerminal(true);
    	}
    }

    /**
     * Detach aggregate listeners from the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Detect if we should use the JsonRenderer based on model type and/or
     * Accept header
     *
     * @param  ViewEvent $e
     * @return null|JsonRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {       
        return $this->renderer;
    }

    /**
     * Inject the response with the JSON payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
       
        //echo $renderer !== $this->renderer;
        /*if ($renderer != $this->renderer) {
        	return;
        }*/
        

        $result   = $e->getResult();
        $response = $e->getResponse();

        // Set content
        // If content is empty, check common placeholders to determine if they are
        // populated, and set the content from them.
        if (empty($result)) {
            $placeholders = $renderer->plugin('placeholder');
            $registry     = $placeholders->getRegistry();
            foreach ($this->contentPlaceholders as $placeholder) {
                if ($registry->containerExists($placeholder)) {
                    $result = (string) $registry->getContainer($placeholder);
                    break;
                }
            }
        }
        $response->setContent($result);
    }
}
