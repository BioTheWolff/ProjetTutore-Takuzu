<?php


/**
 * Classe de traduction entre les messages JS et les grilles PHP.
 *
 * Format du message: `taille:contenu`
 * Exemple: `4:1010010111000011`
 *
 * Format de la grille: matrice d'entiers dont le trou est une constante définie dans la classe
 *
 * @see Adapter::GAP_PHP la constante de 'trou' en interne
 * @see Adapter::GAP_JS la constante de 'trou' dans les messages échangés
 */
class Adapter
{

    const GAP_JS = '_';
    const GAP_PHP = 5;

    /**
     * Transforme la grille interne en message prêt à être envoyé
     *
     * @see Adapter pour la description des formats
     *
     * @param array $grid la grille PHP
     * @return string le message
     */
    public static function grid_to_message(array $grid): string
    {
        $fs = count($grid) . ":";

        foreach ($grid as $row) {
            foreach ($row as $item) {
                if ($item == self::GAP_PHP) $fs .= self::GAP_JS;
                else $fs .= (string)$item;
            }
        }

        return $fs;
    }

    /**
     * Transforme le message reçu en grille interne pour traitement
     *
     * @see Adapter pour la description des formats
     *
     * @param string $message le message reçu
     * @return array la grille
     */
    public static function message_to_grid(string $message): array
    {
        [$size, $chars] = explode(":", $message);
        $size = (int)$size;
        $chars = preg_split('//', $chars, -1, PREG_SPLIT_NO_EMPTY);;

        $grid = [];

        for ($i = 0; $i < $size; ++$i)
        {
            $line = [];

            for ($j = 0; $j < $size; ++$j)
            {
                $c = $chars[$i*$size+$j];

                if ($c == self::GAP_JS) $c = self::GAP_PHP;
                else $c = (int)$c;

                $line[] = $c;
            }

            $grid[] = $line;
        }

        return $grid;
    }

}