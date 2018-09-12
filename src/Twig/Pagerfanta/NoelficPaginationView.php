<?php


namespace App\Twig\Pagerfanta;


use Pagerfanta\View\DefaultView;

class NoelficPaginationView extends DefaultView
{

    protected function createDefaultTemplate()
    {
        return new NoelficPaginationTemplate();
    }

    public function getName(): string
    {
        return 'noelfic_pagination';
    }

}