<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Value\Talk;
use Laminas\View\Helper\AbstractHelper;
use function count;
use function implode;

class RenderTalk extends AbstractHelper
{
    public function __invoke(Talk $talk) : string
    {
        $s = '<li>';

        $s .= '<h3>';

        if ($talk->isTutorial()) {
            $s .= '<strong>Tutorial: </strong>';
        }

        if ($talk->isLightning()) {
            $s .= '<em>Lightning: </em>';
        }

        $s .= $talk->name();
        $s .= ' (' . $talk->event() . ', ' . $talk->date()->format('jS M \'y') . ')';
        $s .= '</h3>';

        $s .= '<p>' . $talk->abstract() . '</p>';

        $links = [];
        foreach ($talk->links() as $text => $linkData) {
            $l  = '<a href="';
            $l .= $linkData['url'] . '"';
            if (isset($linkData['class'])) {
                $l .= ' class="' . $linkData['class'] . '"';
            }
            $l      .= '>' . $text . '</a>';
            $links[] = $l;
        }

        if (count($links)) {
            $s .= '<p><strong>Links: </strong> ';
            $s .= implode(' | ', $links);
            $s .= '</p>';
        }

        $s .= '</li>';

        return $s;
    }
}
