<?php

namespace HMAjaxStrategy\Service;

use HMAjaxStrategy\View\Strategy\AjaxStrategy as Strategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * View Strategy Factory
 */
class ViewStrategyFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \AjaxStrategy\View\Strategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	
        $renderer = $serviceLocator->get('ViewRenderer');
       
        return new Strategy($renderer);
        
    }
}