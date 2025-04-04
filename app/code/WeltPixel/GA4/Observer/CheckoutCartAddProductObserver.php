<?php
namespace WeltPixel\GA4\Observer;

use Magento\Framework\Event\ObserverInterface;

class CheckoutCartAddProductObserver implements ObserverInterface
{
    /**
     * @var \WeltPixel\GA4\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $localeResolver;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;


    /**
     * @param \WeltPixel\GA4\Helper\Data $helper
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param \Magento\Checkout\Model\Session $_checkoutSession
     */
    public function __construct(\WeltPixel\GA4\Helper\Data $helper,
                                \Magento\Framework\Locale\ResolverInterface $localeResolver,
                                \Magento\Checkout\Model\Session $_checkoutSession)
    {
        $this->helper = $helper;
        $this->localeResolver = $localeResolver;
        $this->_checkoutSession = $_checkoutSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_checkoutSession->setAddProductTrigger(false);

        if (!$this->helper->isEnabled()) {
            return $this;
        }

        $product = $observer->getData('product');
        $request = $observer->getData('request');

        $params = $request->getParams();

        if (isset($params['qty'])) {
            $filter = new \Magento\Framework\Filter\LocalizedToNormalized(
                ['locale' => $this->localeResolver->getLocale()]
            );
            $qty = $filter->filter($params['qty']);
        } else {
            $qty = 1;
        }

        if ($product->getTypeId() == \Magento\GroupedProduct\Model\Product\Type\Grouped::TYPE_CODE) {
            $superGroup = $params['super_group'];
            $superGroup = is_array($superGroup) ? array_filter($superGroup, 'intval') : [];

            $associatedProducts =  $product->getTypeInstance()->getAssociatedProducts($product);
            foreach ($associatedProducts as $associatedProduct) {
                if (isset($superGroup[$associatedProduct->getId()]) && ($superGroup[$associatedProduct->getId()] > 0) ) {
                    $currentAddToCartData = $this->_checkoutSession->getGA4AddToCartData();
                    $addToCartPushData = $this->helper->addToCartPushData($superGroup[$associatedProduct->getId()], $associatedProduct);
                    $newAddToCartPushData = $this->helper->mergeAddToCartPushData($currentAddToCartData, $addToCartPushData);
                    $this->_checkoutSession->setGA4AddToCartData($newAddToCartPushData);

                }
            }
        } else {
            $displayOption = $this->helper->getParentOrChildIdUsage();
            $requestParams = [];
            if ( ($displayOption == \WeltPixel\GA4\Model\Config\Source\ParentVsChild::CHILD) && ($product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE)) {
                $params['qty'] = $qty;
                $requestParams = $params;
            }
            $this->_checkoutSession->setGA4AddToCartData($this->helper->addToCartPushData($qty, $product, $requestParams));
        }

        return $this;
    }
}
