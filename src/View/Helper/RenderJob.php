<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Value\Job;
use Laminas\View\Helper\AbstractHelper;

use function count;
use function htmlspecialchars;

use const ENT_QUOTES;

final class RenderJob extends AbstractHelper
{
    public function __invoke(Job $job, int $index): string
    {
        $side = $index % 2 === 0 ? 'left' : 'right';

        $s  = '<li class="timeline-item timeline-item--' . $side . ($job->isCurrent() ? ' timeline-item--current' : '') . '">';
        $s .= '<div class="timeline-item__dot"></div>';
        $s .= '<article class="job-card">';

        $s .= '<div class="job-card__header">';
        if ($job->logoUrl() !== null) {
            $s .= '<img class="job-card__logo" src="' . $this->escape($job->logoUrl()) . '" alt="' . $this->escape($job->company()) . ' logo" width="48" height="48" loading="lazy">';
        } else {
            $s .= '<div class="job-card__logo job-card__logo--placeholder" aria-hidden="true">' . $this->escape($job->initials()) . '</div>';
        }

        $s .= '<div class="job-card__heading">';
        $s .= '<h3 class="job-card__company">';
        $s .= $job->url() !== null
            ? '<a href="' . $this->escape($job->url()) . '">' . $this->escape($job->company()) . '</a>'
            : $this->escape($job->company());
        $s .= '</h3>';
        $s .= '<p class="job-card__title">' . $this->escape($job->title()) . '</p>';
        $s .= '<p class="job-card__meta">' . $job->dateRangeLabel();
        if ($job->isCurrent()) {
            $s .= ' <span class="job-card__badge">Current</span>';
        }

        $s .= '</p>';
        $s .= '</div>';
        $s .= '</div>';

        if (count($job->tags())) {
            $s .= '<span class="tag-list">';
            foreach ($job->tags() as $tag) {
                $s .= '<span class="tag-pill">' . $this->escape($tag) . '</span>';
            }

            $s .= '</span>';
        }

        $s .= '<details class="job-card__details">';
        $s .= '<summary class="job-card__toggle">Read more</summary>';
        $s .= '<div class="job-card__description">' . $job->description() . '</div>';
        $s .= '</details>';

        $s .= '</article>';
        $s .= '</li>';

        return $s;
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }
}
