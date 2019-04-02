<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Exception;
use Zend\View\Helper\AbstractHelper;
use function random_int;

final class SelfAggrandisingQuote extends AbstractHelper
{
    private const QUOTES = [
        'Every project goes better with James.',
        'James is one of the most passionate and talented programmers I\'ve ever met.',
        'James is by far and away the most talented developer I have ever met.',
    ];

    /**
     * @throws Exception
     */
    public function __invoke(): string
    {
        return self::QUOTES[random_int(0, count(self::QUOTES) - 1)];
    }
}
