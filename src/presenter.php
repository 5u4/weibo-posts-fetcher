<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conf';

/**
 * @param string $content
 * @param string $username
 * @return string
 */
function card(string $content, string $username): string
{
    $first = '<div class="row"><div class="col s12 m12 l12"><div class="card yellow lighten-5"><div class="card-content indigo-text text-darken-2"><span class="card-title">';

    $second = '</span><p>';

    $third = '</p></div></div></div></div>';

    return $first . $username . $second . $content . $third;
}
