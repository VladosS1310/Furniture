<?php
/**
 * @category  Apptrian
 * @package   Apptrian_MetaPixelApi
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */

namespace Apptrian\MetaPixelApi\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class MatchingSection implements SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    public $customerSession;
    
    /**
     * @var \Apptrian\MetaPixelApi\Helper\Data
     */
    public $helper;
    
    /**
     * Constructor.
     *
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Apptrian\MetaPixelApi\Helper\Data $helper
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Apptrian\MetaPixelApi\Helper\Data $helper
    ) {
        $this->customerSession = $customerSession;
        $this->helper = $helper;
    }
    
    /**
     * Get user/customer data.
     *
     * @return array
     */
    public function getSectionData()
    {
        $customerData = [];
        $customerId = $this->customerSession->getCustomerId();
        
        if (!$customerId) {
            $customerId = 0;
        }
        
        $customerData = $this->helper->getUserDataForBrowser($customerId);
        
        return [
            'matching_data' => $customerData,
        ];
    }
}
