<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Service\Ratings;
use Asgrim\Value\Talk;
use Laminas\View\Helper\AbstractHelper;

use function count;
use function implode;
use function trim;

final class RenderTalk extends AbstractHelper
{
    public function __construct(private Ratings $ratings)
    {
    }

    public function __invoke(Talk $talk, bool $skipAbstract = false): string
    {
        $titleTag = $skipAbstract ? 'h4' : 'h3';

        $badgeModifier = 'talk';
        $badgeLabel    = 'Talk';
        if ($talk->isTutorial()) {
            $badgeModifier = 'tutorial';
            $badgeLabel    = 'Tutorial';
        } elseif ($talk->isLightning()) {
            $badgeModifier = 'lightning';
            $badgeLabel    = 'Lightning';
        }

        $s  = '<li class="talk-card' . ($skipAbstract ? ' talk-card--compact' : '') . '">';
        $s .= '<div class="talk-card__header">';
        $s .= '<span class="talk-card__badge talk-card__badge--' . $badgeModifier . '">' . $badgeLabel . '</span>';
        $s .= '<' . $titleTag . ' class="talk-card__title">' . $talk->name() . '</' . $titleTag . '>';
        $s .= '</div>';
        $s .= '<p class="talk-card__meta">' . $talk->event() . ' <span class="talk-card__meta-sep">&middot;</span> ' . $talk->date()->format('jS M \'y') . '</p>';

        if (! $skipAbstract) {
            $s .= '<p class="talk-card__abstract">' . $talk->abstract() . '</p>';
        }

        $links = [];
        foreach ($talk->links() as $text => $linkData) {
            $l  = '<a href="';
            $l .= $linkData['url'] . '"';
            if (isset($linkData['class'])) {
                $l .= ' class="' . $linkData['class'] . '"';
            }

            $l .= '>' . $text . '</a>';

            if (isset($linkData['class']) && trim($linkData['class']) === 'joindin') {
                $l .= $this->ratings->ratingForTalk($linkData['url']);
            }

            $links[] = $l;
        }

        if (count($links)) {
            $s .= '<p class="talk-card__links"><strong>Links: </strong> ';
            $s .= implode(' <span class="talk-card__link-sep">|</span> ', $links);
            $s .= '</p>';
        }

        $s .= '</li>';

        return $s;
    }
}
