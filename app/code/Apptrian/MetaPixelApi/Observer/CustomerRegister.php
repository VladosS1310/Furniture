<?php
/**
 * @category  Apptrian
 * @package   Apptrian_MetaPixelApi
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */
 
namespace Apptrian\MetaPixelApi\Observer;

class CustomerRegister implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Apptrian\MetaPixelApi\Helper\Data
     */
    public $helper;
    
    /**
     * Constructor.
     *
     * @param \Apptrian\MetaPixelApi\Helper\Data $helper
     */
    public function __construct(
        \Apptrian\MetaPixelApi\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }
    
    /**
     * Execute method.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return \Apptrian\MetaPixelApi\Observer\CustomerRegister
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $firingMode = $this->helper->getFiringMode();
        
        if ($firingMode != 2) {
            return $this;
        }
        
        $data = [];
        
        $customerId = $observer->getCustomer()->getId();
        
        if ($customerId) {
            $data = $this->helper->getDataForServerCompleteRegistrationEvent($customerId);
        }
        
        if (empty($data)) {
            return $this;
        }
        
        $this->helper->fireServerEvent($data);
        
        return $this;
    }
}
