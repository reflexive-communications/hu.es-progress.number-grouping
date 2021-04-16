<?php

/**
 * Test NumberGrouping Processor
 *
 * @group headless
 */
class CRM_NumberGrouping_ProcessorHeadlessTest extends CRM_NumberGrouping_HeadlessTestCase
{
    /**
     * @throws \API_Exception
     * @throws \Civi\API\Exception\UnauthorizedException
     * @throws \CRM_Core_Exception
     */
    public function testGetSeparators()
    {
        // Set separators
        $decimal = "@";
        $thousand = "?";
        $result = cv(sprintf("api4 Setting.Set +v '%s=%s'", 'monetaryDecimalPoint', $decimal));
        self::assertCount(1, $result, 'Bad number of results from cv');
        $result = cv(sprintf("api4 Setting.Set +v '%s=%s'", 'monetaryThousandSeparator', $thousand));
        self::assertCount(1, $result, 'Bad number of results from cv');

        // Create Config object (this caches settings) and force a rebuild from DB
        CRM_Core_Config::singleton(true, true);

        $expected = [
            'decimal_separator' => $decimal,
            'thousand_separator' => $thousand,
        ];
        self::assertSame($expected, CRM_NumberGrouping_Processor::getSeparators(), 'Bad separators returned');
    }

    public function testFormatNumbers()
    {
        $value = '54326432.54';
        $expected = '54 326 432:540';
        $actual = CRM_NumberGrouping_Processor::formatNumbers($value, 3, ':', " ");
        self::assertSame($expected, $actual, 'Bad value returned for a number');

        $value = ' non-5435-numeric string with #32.221 numbers';
        $expected = ' non-5435-numeric string with #32.221 numbers';
        $actual = CRM_NumberGrouping_Processor::formatNumbers($value, 1, '.', ',');
        self::assertSame($expected, $actual, 'Bad value returned for a non-numeric string');
    }
}
