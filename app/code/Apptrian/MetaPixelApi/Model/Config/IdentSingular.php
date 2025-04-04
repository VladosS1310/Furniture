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

class IdentSingular implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Product SKU as (id)')],
            ['value' => '2', 'label' => __('Child SKU as (id)')],
            ['value' => '3', 'label' => __('Child SKU as (id) and Product SKU as (item_group_id)')]
        ];
    }
}
