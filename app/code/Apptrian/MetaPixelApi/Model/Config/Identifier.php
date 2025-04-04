<?php
/**
 * @category  Apptrian
 * @package   Apptrian_MetaPixelApi
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */
 
namespace Apptrian\MetaPixelApi\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class Identifier implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'sku', 'label' => __('SKU (Recommended)')],
            ['value' => 'id', 'label' => __('ID')]
        ];
    }
}
