<?php

/**
 * All Helper functions
 */

/**
 * print_r with "<pre>"
 */
function pre()
{
    $args = func_get_args();
    foreach ($args as $arg) {
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
    }
}

/**
 * pre() with die
 */
function pred()
{
    call_user_func_array('pre', func_get_args());
    die();
}

/**
 * var_dump with "<pre>"
 */
function ver()
{
    $args = func_get_args();
    foreach ($args as $arg) {
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }
}

/**
 * ver() with die
 */
function verd()
{
    call_user_func_array('ver', func_get_args());
    die();
}

/**
 * Get the full url for files to be uploaded
 *
 * @param string $fileName
 * @param string $slug
 * @return array/string
 */
function upload_url($slug = '')
{
    if($slug)
    {
        $slug = $slug . '/' . date('Y') . '/' . date('m');

        /*if (!file_exists(public_path('assets/uploads/' . $slug)))
        {
            mkdir(public_path('assets/uploads/' . $slug), 0777, true);
        }*/

        return [
            'url' => public_path('assets/uploads/' . $slug),
            'slug' => $slug
        ];
    }
    return public_path('assets/uploads/' . $fileName);
}

/**
 * Get the server url for uploded images
 *
 * @param string $fileName
 * @return string
 */
function getUplodedImgUrl($fileName)
{
    return asset('assets/uploads/' . $fileName);
}

/**
 * Get the full url for images
 *
 * @param string $fileName
 * @return string
 */
function img_url($fileName)
{
    return url('images/' . $fileName);
}

/**
 * Get Random string
 *
 */
function getRandomString($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzqwasedxcvfrtgbnhjmklpoiuy';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
       $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function gender()
{
    return [
        'male' => 'Male',
        'female' => 'Female',
    ];
}

/**
 * Check it is serialize
 * @param  [type]  $data
 * @return boolean
 */
function is_serialized($data)
{
    return (is_string($data) && preg_match("#^((N;)|((a|O|s):[0-9]+:.*[;}])|((b|i|d):[0-9.E-]+;))$#um", $data));
}

/**
 * Get formatted date
 * @param  [type]  $datetime
 * @return boolean
 */
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            //$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            $v = $diff->$k . ' ' . trans_choice('api.helper.'.$v, $diff->$k);
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ' . __('api.helper.ago') : __('api.helper.just_now');
}

/**
 * Get formatted name of table column
 * @param  [type]  $data
 * @return boolean
 */
function getFormattedTableColumnName($name)
{
    return ucwords(str_replace('_', ' ', $name));
}

/**
 * Check given string is a valid date
 * @param  [type]  $dateString
 * @return boolean
 */
function checkIsAValidDate($dateString){
    return (bool)strtotime($dateString);
}