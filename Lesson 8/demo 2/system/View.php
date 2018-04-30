<?php namespace System;

/*
 * View - load template pages
 *
 */
class View {

    /**
     * include template file
     * @param  string  $path  path to file from views folder
     * @param  array $data  array of data
     * @param  array $error array of errors
     */
    public function render($path, $data = false)
    {
        if ($data) {
            // Extract the rendering variables.
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }
        }

        $filepath = APPDIR."views/$path.php";

        if (file_exists($filepath)) {
            require $filepath;
        } else {
            die("View: $path not found!");
        }

    }
}
