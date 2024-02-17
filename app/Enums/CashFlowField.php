<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * List of all possible fields in cash flow of a stock.
 */
final class CashFlowField extends Enum
{
    const OPERATING_CASH_FLOW = 'operating_cash_flow';
    const INVESTING_CASH_FLOW = 'investing_cash_flow';
    const FINANCING_CASH_FLOW = 'financing_cash_flow';
    const END_CASH_POSITION = 'end_cash_position';
    const INCOME_TAX_PAID_SUPPLEMENTAL_DATA = 'income_tax_paid_supplemental_data';
    const INTEREST_PAID_SUPPLEMENTAL_DATA = 'interest_paid_supplemental_data';
    const CAPITAL_EXPENDITURE = 'capital_expenditure';
    const ISSUANCE_OF_CAPITAL_STOCK = 'issuance_of_capital_stock';
    const FREE_CASH_FLOW = 'free_cash_flow';
}
