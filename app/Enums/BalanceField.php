<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * List of all possible fields in balance sheet of a stock.
 */
final class BalanceField extends Enum
{
    const TOTAL_ASSETS = 'total_assets';
    const TOTAL_LIABILITIES_NET_MINORITY_INTEREST = 'total_liabilities_net_minority_interest';
    const TOTAL_EQUITY_GROSS_MINORITY_INTEREST = 'total_equity_gross_minority_interest';
    const TOTAL_CAPITALIZATION = 'total_capitalization';
    const COMMON_STOCK_EQUITY = 'common_stock_equity';
    const CAPITAL_LEASE_OBLIGATIONS = 'capital_lease_obligations';
    const NET_TANGIBLE_ASSETS = 'net_tangible_assets';
    const WORKING_CAPITAL = 'working_capital';
    const INVESTED_CAPITAL = 'invested_capital';
    const TANGIBLE_BOOK_VALUE = 'tangible_book_value';
    const TOTAL_DEBT = 'total_debt';
    const SHARE_ISSUED = 'share_issued';
    const ORDINARY_SHARES_NUMBER = 'ordinary_shares_number';
}
