<?php
/**
 * @category  Apptrian
 * @package   Apptrian_MetaPixelApi
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */
 
namespace Apptrian\MetaPixelApi\Observer;

class FpcPage implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Apptrian\MetaPixelApi\Service\CurrentCustomer
     */
    public $currentCustomer;
    
    /**
     * @var \Apptrian\MetaPixelApi\Helper\Data
     */
    public $helper;
    
    /**
     * Constructor.
     *
     * @param \Apptrian\MetaPixelApi\Service\CurrentCustomer $currentCustomer
     * @param \Apptrian\MetaPixelApi\Helper\Data $helper
     */
    public function __construct(
        \Apptrian\MetaPixelApi\Service\CurrentCustomer $currentCustomer,
        \Apptrian\MetaPixelApi\Helper\Data $helper
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->helper = $helper;
    }
    
    /**
     * Execute method.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return \Apptrian\MetaPixelApi\Observer\FpcPage
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $firingMode = $this->helper->getFiringMode();
        
        if ($firingMode != 2) {
            return $this;
        }
        
        $customerId = $this->currentCustomer->getCustomerId();

        $content = $observer->getEvent()->getResponse()->getContent();
        
        $categoryId = $this->getCategoryId($content);
        $productId  = $this->getProductId($content);
        $search     = $this->getSearch($content);
        $pageUrl    = $this->getPageUrl($content);
        
        if ($productId) {
            $data = $this->helper->getProductDataForServer($productId, $customerId);
        } elseif ($categoryId) {
            $data = $this->helper->getCategoryDataForServer($categoryId, $customerId);
        } elseif ($search) {
            $data = $this->helper->getSearchDataForServer($customerId);
        } elseif ($pageUrl) {
            $data = $this->helper->getDataForServerPageViewEvent($customerId);
        } else {
            $data = '';
        }
        
        if (empty($data)) {
            return $this;
        }
        
        $this->helper->fireServerEvent($data);
        
        return $this;
    }
    
    /**
     * Returns product ID from cached content.
     *
     * @param string $content
     * @return number|string
     */
    public function getProductId($content)
    {
        $productId = 0;
        
        $indexProduct  = preg_match('/apptrianMetaPixelApiProductId=([0-9]+);/', $content, $matches);
        
        if ($indexProduct) {
            $productId = $matches[$indexProduct];
        }
        
        return $productId;
    }
    
    /**
     * Returns category ID from cached content.
     *
     * @param string $content
     * @return number|string
     */
    public function getCategoryId($content)
    {
        $categoryId = 0;
        
        $indexCategory = preg_match('/apptrianMetaPixelApiCategoryId=([0-9]+);/', $content, $matches);
        if ($indexCategory) {
            $categoryId = $matches[$indexCategory];
        }
        
        return $categoryId;
    }
    
    /**
     * Returns search flag from cached content.
     *
     * @param string $content
     * @return number|string
     */
    public function getSearch($content)
    {
        $search = 0;
        
        if (strpos($content, 'apptrianMetaPixelApiSearch=1;') !== false) {
            $search = 1;
        }
        
        return $search;
    }
    
    /**
     * Returns url from cached content.
     *
     * @param string $content
     * @return string
     */
    public function getPageUrl($content)
    {
        $url = 0;
        
        $indexUrl = preg_match('/apptrianMetaPixelApiUrl="(.*)";/', $content, $matches);
        if ($indexUrl) {
            $url = $matches[$indexUrl];
        }
        
        return $url;
    }
}
