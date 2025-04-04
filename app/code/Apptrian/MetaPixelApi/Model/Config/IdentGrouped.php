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

class IdentGrouped implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '2', 'label' => __('Children SKUs as (id)s')],
            ['value' => '3', 'label' => __('Children SKUs as (id)s and Product SKU as (item_group_id)')]
        ];
    }
}
