<?php
	use GutenbergBlocks\Services\Blocks;

	use GutenbergBlocks\Helpers\Consts;

	$blocks = new Blocks();
	$native_blocks = $blocks->get_native_blocks();
	$disabled_blocks = $blocks->get_disabled_blocks();

	$registered_blocks = $blocks->get_registered_blocks();

?>
<form method="post" action="options.php" class="gutenblocks-settings">
	<?php settings_fields('gutenberg-blocks-settings'); ?>
  <?php do_settings_sections('gutenberg-blocks-settings'); ?>

	<header class="gutenblocks-settings__header">
		<div class="gutenblocks-settings__header__inner">
			<img src="<?php echo Consts::get_url().'admin/img/gutenberg-blocks-logo.svg' ?>" alt="Gutenberg Blocks Logo">
			<h1>
				<?php _e('Gutenberg Blocks Settings'); ?>
			</h1>
		</div>
	</header>

	<main class="gutenblocks-settings__content">

		<h2><?php _e('Gutenberg Blocks'); ?></h2>

		<p class="description"><?php _e("Check out these awesome blocks to improve your WordPress experience.", 'gutenblocks'); ?></p>

		<ul class="gutenblocks-list">
			<?php
				foreach($registered_blocks as $block):
					$active = !in_array( $block['id'], $disabled_blocks );
			?>
			<li class="gutenblocks-block<?php if( $active ): ?> is-active<?php endif; ?>">
				<header class="gutenblocks-block__head">
					<div class="gutenblocks-block__icon js-gutenblocks-show-settings">
						<span class="dashicons <?php echo $block['icon']; ?>"></span>
					</div>
					<div class="gutenblocks-block__title js-gutenblocks-show-settings">
						<?php echo $block['name']; ?>
					</div>
					<div class="gutenblocks-block__actions">
							<a href="" class="gutenblocks-block__button js-gutenblocks-show-preview"><?php _e( 'Preview', 'gutenblocks' ); ?></a>
							<a href="" class="gutenblocks-block__button js-gutenblocks-show-settings"><?php _e( 'Settings', 'gutenblocks' ); ?></a>
							<a
								href="#"
								class="gutenblocks-block__button js-gutenblocks-toggle-state"
								data-block="<?php echo $block['id']; ?>"
								data-command=<?php echo ( $active ) ? 'disable' : 'enable'; ?>
								data-invert-command=<?php echo ( !$active ) ? 'disable' : 'enable'; ?>
								data-invert-label=<?php echo ( !$active ) ? __( 'Disable', 'gutenblocks' ) : __( 'Enable', 'gutenblocks' ); ?>
							>
								<?php echo ( $active ) ? __( 'Disable', 'gutenblocks' ) : __( 'Enable', 'gutenblocks' ); ?>
							</a>
					</div>
				</header>

				<div class="gutenblocks-block__settings">
					<?php call_user_func( $block['options_callback'] ); ?>

          <hr>

          <img src="<?php echo $block['preview_image']; ?>" alt="<?php sprintf( __( '%s example', 'gutenblocks' ), $block['name'] ); ?>">
				</div>

			</li>
			<?php endforeach; ?>
		</ul>


		<h2><?php _e('Default WordPress blocks', 'gutenblocks'); ?></h2>

		<p class="description"><?php _e("Disable the blocks you don't want to deal with for a lighter user interface.", 'gutenblocks'); ?></p>

		<ul class="gutenblocks-list">
			<?php
				foreach($native_blocks as $key => $block):
					$active = !in_array( $block['id'], $disabled_blocks );
			?>
			<li class="gutenblocks-block<?php if ( $active ) : ?> is-active<?php endif; ?>">
				<header class="gutenblocks-block__head">
					<div class="gutenblocks-block__icon">
						<span class="dashicons <?php echo $block['icon']; ?>"></span>
					</div>
					<div class="gutenblocks-block__title">
						<?php echo $block['name']; ?>
					</div>
					<div class="gutenblocks-block__actions">
						<a href="" class="gutenblocks-block__button js-gutenblocks-show-settings"><?php _e( 'Settings', 'gutenblocks' ); ?></a>

            <?php if( $block['can_disable'] ): ?>
						<a
							href="#"
							class="gutenblocks-block__button js-gutenblocks-toggle-state"
							data-block="<?php echo $block['id']; ?>"
							data-command=<?php echo ( $active ) ? 'disable' : 'enable'; ?>
							data-invert-command=<?php echo ( !$active ) ? 'disable' : 'enable'; ?>
							data-invert-label=<?php echo ( !$active ) ? __( 'Disable', 'gutenblocks' ) : __( 'Enable', 'gutenblocks' ); ?>
						>
							<?php echo ( $active ) ? __( 'Disable', 'gutenblocks' ) : __( 'Enable', 'gutenblocks' ); ?>
						</a>
            <?php endif; ?>
					</div>
				</header>

				<div class="gutenblocks-block__settings">
				</div>
			</li>
			<?php
				endforeach;
			?>
		</ul>

	</main>

</form>