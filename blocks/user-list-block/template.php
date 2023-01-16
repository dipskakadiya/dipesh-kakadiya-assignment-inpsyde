<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-
use Inpsyde\JsonRestApiIntegration\RestLayer\User\UsersRestCollector;

$usersDataObject = new UsersRestCollector();
$usersFields = $usersDataObject->fields();
$usersData = $usersDataObject->data();

?>
<div class="user-list alignwide">
    <table>
        <thead>
        <tr>
            <?php foreach ($usersFields as $field => $fieldLabel) { ?>
                <th><?php echo esc_html($fieldLabel); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usersData['users'] as $user) { ?>
            <tr>
                <?php foreach ($usersFields as $field => $fieldLabel) { ?>
                    <td>
                        <?php
                        switch ($field) {
                            case 'id':
                            case 'name':
                            case 'username':
                                ?>
                                <a class="user-detail-popup"
                                    href="#<?php echo esc_attr($user->__get('id')); ?>">
                                    <?php echo esc_html($user->__get($field)); ?>
                                </a>
                                <?php
                                break;
                            case 'avatar':
                                ?>
                                <a class="user-detail-popup"
                                    href="#<?php echo esc_attr($user->__get('id')); ?>">
                                    <img
                                        alt="<?php echo esc_attr($user->__get('name')); ?>"
                                        src="<?php echo esc_url($user->__get($field)); ?>">
                                </a>
                                <?php
                                break;
                            default:
                                echo esc_html($user->__get($field));
                        }
                        ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div id="user-detail-popup" class="popup alignfull hide">
    <div class="popup-container">
        <a class="close-popup">×</a>
        <div id="user-detail-popup-loader" class="spinner-container">
            <span class="spinner dashicons dashicons-image-rotate"></span>
            <span>
                <?php esc_html_e('Fetching User details...', 'json-rest-api-integration'); ?>
            </span>
        </div>
        <div class="popup-content"></div>
    </div>
</div>
