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

class Compatibility implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default Frontend')],
            ['value' => 'breeze', 'label' => __('Breeze Frontend')],
            ['value' => 'hyva', 'label' => __('Hyvä Frontend')]
        ];
    }
}
