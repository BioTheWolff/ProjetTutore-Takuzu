<?php


class VisualController
{

    public static function index()
    {
        RenderEngine::render("index", "Accueil");
    }

    public static function regle(){
        RenderEngine::render("regle","Regle");
    }

    public static function contact(){
        RenderEngine::render("contact","Contact");
    }

    public static function play()
    {
        RenderEngine::render("play", "Jeu");
    }
}
