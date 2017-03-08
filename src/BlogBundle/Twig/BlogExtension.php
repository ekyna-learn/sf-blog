<?php

namespace BlogBundle\Twig;

/**
 * Class BlogExtension
 * @package BlogBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class BlogExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'summary',
                [$this, 'getSummary'],
                ['is_safe' => ['html']]
            )
        ];
    }

    public function getSummary($html)
    {
        return substr(strip_tags($html), 0, 200) . '&hellip;';
    }
}
