<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Laminas\View\Helper\AbstractHelper;

use function count;
use function htmlspecialchars;
use function log;
use function max;
use function min;
use function round;

use const ENT_QUOTES;

final class RenderTagCloud extends AbstractHelper
{
    private const int MIN_WEIGHT = 1;
    private const int MAX_WEIGHT = 5;

    /** @param array<string, int> $tagCounts */
    public function __invoke(array $tagCounts): string
    {
        if (count($tagCounts) === 0) {
            return '';
        }

        $min = min($tagCounts);
        $max = max($tagCounts);

        $s = '<ul class="tag-cloud">';
        foreach ($tagCounts as $tag => $count) {
            $weight = $this->weightFor($count, $min, $max);
            $s     .= '<li class="tag-cloud__item tag-cloud__item--weight-' . $weight . '">' . $this->escape($tag) . '</li>';
        }

        $s .= '</ul>';

        return $s;
    }

    private function weightFor(int $count, int $min, int $max): int
    {
        if ($min === $max) {
            return self::MAX_WEIGHT;
        }

        // Logarithmic scale, since one or two heavily-used tags (e.g. "PHP") would otherwise
        // dwarf everything else on a linear scale and flatten less common tags to the same size.
        $ratio = (log($count) - log($min)) / (log($max) - log($min));
        $range = (float) (self::MAX_WEIGHT - self::MIN_WEIGHT);

        return self::MIN_WEIGHT + (int) round($ratio * $range);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }
}
