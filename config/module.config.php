<?php 
return array(
    'service_manager'=>array(
        'factories' => array(
            'AjaxStrategy' => 'HMAjaxStrategy\Service\ViewStrategyFactory',
        ),
    ),
    'view_manager' => array(
        'strategies'   => array(
            'AjaxStrategy',
        ),
    ),
);
?>