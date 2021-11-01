<?php

/**
 * Classe qui s'occupe de vérifier que les input utilisateur et les données transmises par
 * le javascript sont saines et correctes
 */
class Douane
{

    /**
     * Vérifie que le message de grille donné par le javascript est de forme acceptable
     *
     * @param string $m le message à vérifier
     * @return bool true si l'entrée est acceptable
     */
    public static function message(string $m): bool
    {
        // si le message est vide
        if (empty($m)) return false;

        // si le message contient autre chose que des chiffres, des deux-points et des underscores
        if (preg_match("/[^0-9_:]/", $m)) return false;

        // si le message n'est pas de la forme "taille:contenu"
        if (!preg_match("/^[0-9]+:[01_]+$/", $m)) return false;

        [$size, $_] = explode(":", $m);
        $size = (int)$size;
        $content_size = $size*$size;

        // si le message n'as pas une taille de contenu égale à taille**2
        if (!preg_match("/^$size:[01_]{{$content_size}}$/", $m)) return false;

        return true;
    }

}