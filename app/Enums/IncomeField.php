<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * List of all possible fields in income statement of a stock.
 */
final class IncomeField extends Enum
{
    const TOTAL_REVENUE = 'total_revenue';
    const OPERATING_REVENUE = 'operating_revenue';
    const COST_OF_REVENUE = 'cost_of_revenue';
    const GROSS_PROFIT = 'gross_profit';
    const OPERATING_EXPENSE = 'operating_expense';
    const OPERATING_INCOME = 'operating_income';
    const NET_NON_OPERATING_INTEREST_INCOME_EXPENSE = 'net_non_operating_interest_income_expense';
    const OTHER_INCOME_EXPENSE = 'other_income_expense';
    const PRETAX_INCOME = 'pretax_income';
    const TAX_PROVISION = 'tax_provision';
    const NET_INCOME_COMMON_STOCKHOLDERS = 'net_income_common_stockholders';
    const DILUTED_NI_AVAILABLE_TO_COM_STOCKHOLDERS = 'diluted_ni_available_to_com_stockholders';
    const BASIC_EPS = 'basic_eps';
    const DILUTED_EPS = 'diluted_eps';
    const BASIC_AVERAGE_SHARES = 'basic_average_shares';
    const DILUTED_AVERAGE_SHARES = 'diluted_average_shares';
    const TOTAL_OPERATING_INCOME_AS_REPORTED = 'total_operating_income_as_reported';
    const TOTAL_EXPENSES = 'total_expenses';
    const NET_INCOME_FROM_CONTINUING_AND_DISCONTINUED_OPERATION = 'net_income_from_continuing_and_discontinued_operation';
    const NORMALIZED_INCOME = 'normalized_income';
    const INTEREST_INCOME = 'interest_income';
    const INTEREST_EXPENSE = 'interest_expense';
    const NET_INTEREST_INCOME = 'net_interest_income';
    const EBIT = 'ebit';
    const EBITDA = 'ebitda';
    const RECONCILED_COST_OF_REVENUE = 'reconciled_cost_of_revenue';
    const RECONCILED_DEPRECIATION = 'reconciled_depreciation';
    const NET_INCOME_FROM_CONTINUING_OPERATION_NET_MINORITY_INTEREST = 'net_income_from_continuing_operation_net_minority_interest';
    const TOTAL_UNUSUAL_ITEMS_EXCLUDING_GOODWILL = 'total_unusual_items_excluding_goodwill';
    const TOTAL_UNUSUAL_ITEMS = 'total_unusual_items';
    const NORMALIZED_EBITDA = 'normalized_ebitda';
    const TAX_RATE_FOR_CALCS = 'tax_rate_for_calcs';
    const TAX_EFFECT_OF_UNUSUAL_ITEMS = 'tax_effect_of_unusual_items';
}
