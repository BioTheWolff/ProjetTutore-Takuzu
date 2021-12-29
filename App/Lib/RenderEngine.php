<?php


/**
 * @codeCoverageIgnore
 */
class RenderEngine
{

    public static function render(string $file_name, string $page_name)
    {
        $rvar_page_title = $page_name;
        $rvar_file_name = $file_name;

        require_once(Path::get_path("view", "_template"));
    }

}