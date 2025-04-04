<?php
/**
 * @category  Apptrian
 * @package   Apptrian_MetaPixelApi
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */
 
namespace Apptrian\MetaPixelApi\Model\Config;

use Magento\Framework\Exception\LocalizedException;

class PixelId extends \Magento\Framework\App\Config\Value
{
    /**
     * Validate and prepare data before saving config value.
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        
        $pattern = '/^[0-9,]+$/';
        $validator = preg_match($pattern, $value);
        
        if (!$validator) {
            $message = __('Please correct Meta Pixel ID: "%1".', $value);
            throw new LocalizedException($message);
        }
        
        return $this;
    }
}
