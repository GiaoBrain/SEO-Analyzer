<?php

/**
 * Format the page titles.
 *
 * @param null $value
 * @return string|null
 */
function formatTitle($value = null)
{
    if (is_array($value)) {
        return implode(" - ", $value);
    }

    return $value;
}

/**
 * Format money.
 *
 * @param $amount
 * @param $currency
 * @param bool $separator
 * @param bool $translate
 * @return string
 */
function formatMoney($amount, $currency, $separator = true, $translate = true)
{
    if (in_array(strtoupper($currency), config('currencies.zero_decimals'))) {
        return number_format($amount, 0, $translate ? __('.') : '.', $separator ? ($translate ? __(',') : ',') : false);
    } else {
        return number_format($amount, 2, $translate ? __('.') : '.', $separator ? ($translate ? __(',') : ',') : false);
    }
}

/**
 * Get and format the Gravatar URL.
 *
 * @param $email
 * @param int $size
 * @param string $default
 * @param string $rating
 * @return string
 */
function gravatar($email, $size = 80, $default = 'identicon', $rating = 'g')
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= '?s='.$size.'&d='.$default.'&r='.$rating;
    return $url;
}

/**
 * Format bytes to the metric system.
 *
 * @param $number
 * @param $decimals
 * @param $decimalSeparator
 * @param $thousandsSeparator
 * @return string
 */
function formatBytes($number, $decimals, $decimalSeparator, $thousandsSeparator)
{
    $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $power = $number > 0 ? floor(log($number, 1000)) : 0;
    return number_format($number / pow(1000, $power), $decimals, $decimalSeparator, $thousandsSeparator) . ' ' . $units[$power];
}

/**
 * Create the container and format an array to HTML.
 *
 * @param $data
 * @param array $container
 * @param array $subContainer
 * @param array $rowContainer
 * @param array $keyContainer
 * @param array $valueContainer
 * @return string
 */
function arrayToHtml($data, $container = [], $subContainer = [], $rowContainer = [], $keyContainer = [], $valueContainer = []) {
    echo $container[0] ?? null;
    echo formatArrayToHtml($data, $subContainer, $rowContainer, $keyContainer, $valueContainer) . ($container[1] ?? null);
    echo $container[1] ?? null;
}

/**
 * Format a multi-dimensional array to HTML.
 *
 * @param $data
 * @param array $subContainer [opening tag, closing tag]
 * @param array $rowContainer [opening tag, closing tag]
 * @param null $keyContainer [opening tag, closing tag]
 * @param null $valueContainer [opening tag, closing tag]
 */
function formatArrayToHtml($data, $subContainer = [], $rowContainer = [], $keyContainer = [], $valueContainer = []) {
    foreach($data as $key => $value) {
        if(!is_array($value)) {
            echo ($rowContainer[0] ?? null) . ($keyContainer[0] ?? null) . e($key) . ($keyContainer[1] ?? null) . ($valueContainer[0] ?? null) . e($value) . ($valueContainer[1] ?? null) . ($rowContainer[1] ?? null);
        } else {
            echo ($rowContainer[0] ?? null) . ($keyContainer[0] ?? null) . e($key) . ($keyContainer[1] ?? null) . ($subContainer[0] ?? null);
            formatArrayToHtml($value, $subContainer, $rowContainer, $keyContainer, $valueContainer);
            echo ($subContainer[1] ?? null) . ($rowContainer[1] ?? null);
        }
    }
}

/**
 * Remove the http and www prefixes from an URL string.
 *
 * @param $url
 * @return array|string|string[]
 */
function cleanUrl($url)
{
    return str_replace(['https://www.', 'http://www.', 'https://', 'http://'], '', (parse_url($url, PHP_URL_PATH) == '/' ? rtrim($url, '/') : $url));
}

/**
 * Convert a number into a readable one.
 *
 * @param   int   $number  The number to be transformed
 * @return  string
 */
function shortenNumber($number)
{
    $suffix = ["", "K", "M", "B"];
    $precision = 1;
    for($i = 0; $i < count($suffix); $i++) {
        $divide = $number / pow(1000, $i);
        if($divide < 1000) {
            return round($divide, $precision).$suffix[$i];
        }
    }

    return $number;
}