<?php

require_once 'conf';

/**
 * @param string $content
 * @param string $username
 * @return string
 */
function card(string $content, string $username): string
{
    $first = '<div class="row"><div class="col s12 m6"><div class="card blue lighten-3 darken-1"><div class="card-content white-text"><span class="card-title">';

    $second = '</span><p>';

    $third = '</p></div></div></div></div>';

    return $first . $username . $second . $content . $third;
}
