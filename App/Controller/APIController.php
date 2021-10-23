<?php

require_once(Path::get_path("l", "Adapter"));
require_once(Path::get_path("m", "GridVerifier"));


class APIController
{

    public static function check(): string
    {
        return GridVerifier::partial_verify(Adapter::message_to_grid($_GET['message']));
    }

}