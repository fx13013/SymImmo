<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigImageExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('urlImage', [$this, 'isUrl']),
        ];
    }

    public function isUrl($filename)
    {
        $pattern = "/^https?/";
        return preg_match($pattern, $filename);
    }
}