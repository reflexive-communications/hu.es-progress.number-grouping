<?php

/**
 * Processor
 *
 * @package  number-grouping
 * @author   Sandor Semsey <sandor@es-progress.hu>
 * @license  AGPL-3.0
 */
class CRM_NumberGrouping_Processor
{
    /**
     * Default number of decimals for formatting
     */
    public const DEFAULT_DECIMALS = 0;

    /**
     * Get relevant settings
     *
     * @return array
     *
     * @throws \API_Exception
     * @throws \CRM_Core_Exception
     * @throws \Civi\API\Exception\UnauthorizedException
     */
    public static function getSeparators()
    {
        $options = [];
        $options['decimal_separator'] = CRM_RcBase_Api_Get::settingValue('monetaryDecimalPoint');
        $options['thousand_separator'] = CRM_RcBase_Api_Get::settingValue('monetaryThousandSeparator');

        return $options;
    }

    /**
     * Format numbers
     *
     * @param mixed $value Value to format
     * @param int $decimals Number of decimals
     * @param string $decimal_separator Decimal separator
     * @param string $thousand_separator Thousand separator
     *
     * @return mixed|string Formatted number
     */
    public static function formatNumbers($value, int $decimals, string $decimal_separator, string $thousand_separator)
    {
        // Not numeric --> return unchanged
        if (!is_numeric($value)) {
            return $value;
        }

        return number_format($value, $decimals, $decimal_separator, $thousand_separator);
    }
}
