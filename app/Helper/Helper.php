<?php

namespace App\Helper;

use Illuminate\Http\UploadedFile;

class Helper
{
    /**
     * Load file(s) from uploaded file(s)
     *
     * @param UploadedFile|string|null $request
     * @param string|null $path
     * @param string|null $filename
     * @return ?string
     */
    public static function fileUpload(UploadedFile|string|null $request = null, ?string $path = null, ?string $filename = 'default.png'): ?string
    {
        if ($request != null || trim($request) != '') {
            $file = $request;
            $dt = now();
            $shuffle = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $shuffle;
            $file->move($path, $fileName);
            return $fileName;
        } else {
            return $filename;
        }
    }

    public static function setActive($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }

    public static function setShow($path, $show = 'show')
    {
        return call_user_func_array('Request::is', (array)$path) ? $show : '';
    }

    public static function formatDate($array): string
    {
        return date('Y-m-d', strtotime($array));
    }

    public static function num_row($page, $limit): float|int
    {
        if (is_null($page)) {
            $page = 1;
        }
        return ($page * $limit) - ($limit - 1);
    }

}
