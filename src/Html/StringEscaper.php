<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Méthode qui permet de protéger les caractères spéciaux succeptibles de dégrader la page Web concernée
     * @param string|null $string $string
     * @return string
     */
    public function escapeString(?string $string = null): string
    {
        if ($string === null) {
            $html = "";
        } else {
            $html = htmlspecialchars($string, ENT_QUOTES | ENT_IGNORE | ENT_HTML5);
        }
        return $html;
    }

    public function stripTagsAndTrim(?string $text): string
    {
        $clean = strip_tags($text);
        if (trim($clean) === null) {
            $clean = "";
        } else {
            $clean = trim($clean);
        }
        return $clean;
    }
}
