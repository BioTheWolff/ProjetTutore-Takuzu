<?php


class VisualController
{

    public static function index()
    {
        RenderEngine::render("index", "Accueil");
    }

}