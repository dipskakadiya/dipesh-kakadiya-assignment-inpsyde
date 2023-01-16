<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

get_header();
?>
    <article <?php post_class(); ?>>
        <header class="entry-header alignwide">
            <h1 class="entry-title"><?php esc_html_e('User Lists', 'json-rest-api-integration'); ?></h1>
        </header>
        <div class="entry-content">
            <?php echo wp_kses_post(
                do_blocks('<!-- wp:inpsyde-blocks/user-list-block /-->')
            ); ?>
        </div>
    </article>

<?php
get_footer();

