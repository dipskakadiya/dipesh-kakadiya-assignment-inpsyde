<?php

declare(strict_types=1);

# -*- coding: utf-8 -*-
use Inpsyde\JsonRestApiIntegration\RestLayer\User\UsersRestCollector;

$usersDataObject = new UsersRestCollector();
$usersFields = $usersDataObject->fields();
$usersData = $usersDataObject->data();

?>
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
                                <a href="#" data-id="<?php echo esc_attr($user->__get('id')); ?>">
                                    <?php echo esc_html($user->__get($field)); ?>
                                </a>
                                <?php
                                break;
                            case 'avatar':
                                ?>
                                <a href="#" data-id="<?php echo esc_attr($user->__get('id')); ?>">
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
