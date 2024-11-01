<?php

use DoatKolom\Ui\Components\Notification;
use DoatKolom\Ui\Components\Tab;
?>

<div class="superdocs doatkolom-ui">
    <div class="pr-5">
        <div class="rounded overflow-hidden shadow-md bg-white mt-5 pb-7">
            <div class="rounded-xl">
                <div class="min-h-[38rem] p-10">
					<div class="pb-14">
                        <div>
                            <h4 class="text-[20px] font-bold font-primary text-heading mb-9 inline">Settings</h4>
                        </div>
						<div class="mt-6">
							<?php
								$tab = new Tab;
								$tab->render( [
									'init'     => true,
									'position' => 'top',
									'classes'  => [
										'tabpanels' => 'bg-white',
										'selectedButton' => '!text-primary'
									]
								], [
									[
										'title'             => esc_html__('General', 'superdocs'),
										'content_api'       => get_rest_url( null, 'superdocs/settings/general' ),
										'contentCache'      => true,
										'contentApiOptions' => [
											'headers' => [
												'X-WP-Nonce' => wp_create_nonce( 'wp_rest' )
											]
										],
									]
								] );
							?>
                    	</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<?php
	$notification = new Notification;
	$notification->render();
	?>
</div>

