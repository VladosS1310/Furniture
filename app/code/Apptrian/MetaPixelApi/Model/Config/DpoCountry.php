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

class DpoCountry extends \Magento\Framework\App\Config\Value
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
        
        $pattern = '/^[\p{L}\p{N}_,;:!&#\[\]\=\+\*\$\?\|\'\.\-]*$/iu';
        $validator = preg_match($pattern, $value);
        
        if (!$validator) {
            $message = __(
                'Data Processing Options for Country are not valid.'
            );
            throw new LocalizedException($message);
        }
        
        return $this;
    }
}
