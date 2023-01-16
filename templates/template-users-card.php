<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-

?>
<script type="text/html" id="tmpl-user-card">
    <div class="card card-user">
        <img class="avatar" src="{{data.avatar}}" alt="Avatar">
        <div class="container">
            <h4>
                <b>{{data.name}}</b>
                <span>({{data.username}}</span>
            </h4>
            <div id="card-user-company" class="card-user--company">
                {{data.company}}
            </div>
            <div class="card-user--contact">
                <div class="card-user--email">
                    <span class="dashicons dashicons-email"></span>
                    <span>
                        <a id="card-user-email" href="mailto:{{data.email}}">
                            {{data.email}}
                        </a>
                    </span>
                </div>
                <div class="card-user--phone">
                    <span class="dashicons dashicons-phone"></span>
                    <span>
                        <a id="card-user-phone" href="tel:{{data.phone}}">
                            {{data.phone}}
                        </a>
                    </span>
                </div>
                <div class="card-user--website">
                    <span class="dashicons dashicons-admin-site"></span>
                    <span>
                        <a id="card-user-site" href="http://{{data.website}}">
                            {{data.website}}
                        </a>
                    </span>
                </div>
            </div>

            <address class="card-user--address">
                <span class="dashicons dashicons-location"></span>
                <span id="card-user-address">
                    {{data.address}}
                </span>
            </address>

            <div class="card-user--map">
                <a id="card-user-map" target="_blank"
                    href="https://maps.google.com/maps?q=24.197611,120.780512">
                    <?php esc_html_e('Open Google Map', 'json-rest-api-integration'); ?>
                </a>
            </div>
        </div>
    </div>
</script>

