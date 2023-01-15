<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Inpsyde\JsonRestApiIntegration;

/**
 * Class UserPageBuilder
 *
 * @package Inpsyde\JsonRestApiIntegration
 */
final class UserPageBuilder
{
    /**
     * @return void
     */
    public function init(): void
    {
        add_action('init', [ $this, 'registerPage' ]);
        add_filter('template_include', [ $this, 'handlePageRequest' ]);
        add_filter('query_vars', [ $this, 'updateQueryVars' ]);
    }

    /**
     * Register User page.
     */
    public function registerPage()
    {
        add_rewrite_rule('^users-table$', 'index.php?userspage=1', 'top');
    }

    /**
     * Add Custom query vars.
     *
     * @param array $vars query_vars.
     *
     * @return array
     */
    public function updateQueryVars(array $vars): array
    {
        $vars[] = 'userspage';

        return $vars;
    }

    public function handlePageRequest(string $template): string
    {
        if (get_query_var('userspage', false) !== false && ! wp_is_block_theme()) {
            $customTemplate = locate_template([ 'template-users-table.php' ]);
            if ('' !== $customTemplate) {
                return $customTemplate;
            }

            //Check plugin directory next
            $customTemplate = JsonRestApiIntegration::pathTo('templates/template-users-table.php');
            if (file_exists($customTemplate)) {
                return $customTemplate;
            }
        }

        return $template;
    }
}
