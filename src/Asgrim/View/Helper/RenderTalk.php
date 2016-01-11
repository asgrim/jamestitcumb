<?php

namespace Asgrim\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class RenderTalk extends AbstractHelper
{
    public function __invoke(array $talk)
    {
        $s = '<li>';

        $s .= '<h3>';

        if ($talk['type'] === 'tutorial') {
            $s .= '<strong>Tutorial: </strong>';
        }

        if ($talk['type'] === 'lightning') {
            $s .= '<em>Lightning: </em>';
        }

        $s .= $talk['name'];
        $s .= ' (' . $talk['event'] . ', ' . $talk['date']->format('jS M \'y') . ')';
        $s .= '</h3>';

        $s .= '<p>' . $talk['abstract'] . '</p>';

        $links = [];
        foreach ($talk['links'] as $text => $linkData) {
            $l = '<a href="';
            $l .= $linkData['url'];
            if (isset($linkData['class'])) {
                $l .= '" class="' . $linkData['class'] . '"';
            }
            $l .= '">' . $text . '</a>';
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
