<?php


namespace App\Twig\Pagerfanta;


use Pagerfanta\View\Template\TwitterBootstrap4Template;

class NoelficPaginationTemplate extends TwitterBootstrap4Template
{

    static protected $defaultOptions = array(
        'prev_message'        => '<i class="fa fa-angle-left"></i>',
        'next_message'        => '<i class="fa fa-angle-right"></i>',
        'dots_message'        => '&hellip;',
        'active_suffix'       => '',
        'css_container_class' => 'pagination',
        'css_prev_class'      => 'prev',
        'css_next_class'      => 'next',
        'css_disabled_class'  => 'disabled',
        'css_dots_class'      => 'disabled',
        'css_active_class'    => 'active',
        'rel_previous'        => 'prev',
        'rel_next'            => 'next'
    );

    public function getName(): string
    {
        return 'noelfic_pagination_template';
    }

}