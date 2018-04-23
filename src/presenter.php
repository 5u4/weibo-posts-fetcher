<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conf';

/**
 * @param string $content
 * @param string $username
 * @param array $images
 * @return string
 */
function card(string $content, string $username, array $images): string
{
    $card =
        '<div class="row">
            <div class="col s12 m12 l12">
                <div class="card yellow lighten-5">
                    <div class="card-content indigo-text text-darken-2">
                        <span class="card-title">' .
                            $username . '
                        </span>
                        <p>' .
                            $content . '
                        </p>
                    </div>';
    foreach ($images as $image) {
        $card .= '
                    <div class="card-image">
                        <img src="' . $image . '">
                    </div>';
    }
    $card .=
                '</div>
            </div>
        </div>';

    return $card;
}

/**
 * @param int $weiboId
 * @param string $imageQuality
 * @param string $imageName
 * @return string
 */
function parseImageUri(int $weiboId, string $imageQuality, string $imageName): string
{
    return ltrim(STORING_LOCATION, '.') . '/images/' . (string)$weiboId . '/' . $imageQuality . '/' . $imageName;
}
