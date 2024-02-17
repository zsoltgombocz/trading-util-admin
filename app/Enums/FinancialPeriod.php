<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * It describes whether financial data is annual or quarterly.
 */
final class FinancialPeriod extends Enum
{
    const ANNUAL = 'annual';
    const QUARTERLY = 'quarterly';
}
