<?php


class VisualController
{

    public static function index()
    {
        RenderEngine::render("index", "Accueil");
    }

    public static function play()
    {
        RenderEngine::render("play", "Jeu");
    }
}
