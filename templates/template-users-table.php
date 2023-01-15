<?php

use \Inpsyde\JsonRestApiIntegration\RestLayer\User\UsersRestCollector;

$usersDataObject = new UsersRestCollector();
$usersFields     = $usersDataObject->fields();
$usersData       = $usersDataObject->data();

get_header();
?>
	<article <?php post_class(); ?>>
		<header class="entry-header alignwide">
			<h1 class="entry-title">User Lists</h1>
		</header>
		<div class="entry-content">
			<table>
				<thead>
				<tr>
					<?php foreach ( $usersFields as $field => $fieldLabel ) { ?>
						<th><?php echo esc_html( $fieldLabel ); ?></th>
					<?php } ?>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $usersData['users'] as $user ) { ?>
					<tr>
						<?php foreach ( $usersFields as $field => $fieldLabel ) { ?>
							<td>
								<?php
								if ( in_array( $field, [ 'id', 'name', 'username' ], true ) ) {
									?>
									<a href="#"
										data-id="<?php echo esc_attr( $user->__get( 'id' ) ); ?>"><?php echo esc_html( $user->__get( $field ) ); ?></a>
									<?php
								} else {
									echo esc_html( $user->__get( $field ) );
								}
								?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</article>

<?php
get_footer();

