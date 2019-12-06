<?php

namespace BilliePayment\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;

/**
 * Subscriber to register the plugin template directory before dispatch.
 */
class TemplateRegistration implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param string $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
            'Enlight_Controller_Action_PostDispatch_Backend_Index' => 'addMenuItem'
        ];
    }

    /**
     * Add Menu item sprite class
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function addMenuItem(Enlight_Controller_ActionEventArgs $args)
    {
        $controller = $args->getSubject();
        $view = $controller->View();

        if ($view->hasTemplate()) {
            $view->extendsTemplate('backend/billie_overview/menuitem.tpl');
        }
    }

    /**
     * Add template dir prior dispatching views.
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onPreDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $controller = $args->getSubject();
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }
}
