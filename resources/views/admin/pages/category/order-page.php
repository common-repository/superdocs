
<?php

use DoatKolom\Ui\Components\Accordion;
use DoatKolom\Ui\Utils\Common;
use SuperDocs\Bootstrap\Utils;
use SuperDocs\Bootstrap\View;

$headers = [
	'headers' => [
		'X-WP-Nonce' => wp_create_nonce( 'wp_rest' )
	]
];

$categoryActionKey     = 'superdocs_category_action_' . $productId;
$categoryDataKey       = Common::generateRandomString( 10 );
$categoriesSortList    = superdocs_get_post_meta_unserialize($productId, 'categories');

if( empty( $categoriesSortList ) ) {
	$categoriesSortList[] = ['categoryPostId' => 0];
}

$items = [];

global $superDocsIds;
$superDocsIds = [];

function superdocs_category_content($productId, $categoryId, $docs = []) {
	?>
	<div class="grid gap-3 grid-cols-1 px-6 py-4 <?php wp_commander_render('superdocs_product_content_'. $productId) ?>" data-category="<?php wp_commander_render($categoryId)?>">
		<?php foreach ($docs as $key => $doc): 
			global $superDocsIds;
			array_push($superDocsIds, $doc->ID);
		?>
			<div class="bg-slate-50 font-primary capitalize shadow p-2" data-doc="<?php wp_commander_render($doc->ID) ?>">
				<div class="float-left">
					<?php wp_commander_render(Common::moveIcon()) ?>
				</div>
				<div class="float-left pl-2"><?php wp_commander_render($doc->post_title)?></div>
				<div class="float-right">
					<a href="<?php wp_commander_render( get_permalink($doc) )?>" target="_blank" class="rounded-md text-xs px-4 py-0.5 shadow text-neutral-50 !bg-success">
						<?php esc_html_e('View', 'superdocs')?>
					</a>
					<a href="<?php wp_commander_render( get_edit_post_link($doc) )?>" type="button" class="rounded-md text-xs px-4 py-0.5 shadow text-neutral-50 !bg-amber-400">
						<?php esc_html_e('Edit', 'superdocs')?>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

foreach($categoriesSortList as $categorySort) {
	if($categorySort['categoryPostId'] != 0) {
		$category = get_post($categorySort['categoryPostId']);
		array_push($items, [
			'title' => $category->post_title,
			'head' => function() use( $category, $categoryActionKey ) {
				?>
					<div x-data="<?php wp_commander_render($categoryActionKey)?>">
						<button type="button" x-on:click="showCategoryEditAlert($data)" class="rounded-md text-xs px-4 py-0.5 shadow text-neutral-50 !bg-amber-400" data-categorypostid="<?php wp_commander_render($category->ID) ?>">
							<?php esc_html_e('Edit', 'superdocs')?>
						</button>
						<button type="button" x-on:click="showCategoryDeleteAlert($data)" class="rounded-md text-xs px-4 py-0.5 mr-7 shadow text-neutral-50 !bg-danger hover:bg-danger-hover" data-categorypostid="<?php wp_commander_render($category->ID)?>">
							<?php esc_html_e('Delete', 'superdocs')?>
						</button>
					</div>
				<?php
			},
			'content' => function() use($categorySort, $category, $productId) {
				$docs = [];
				if(!empty($categorySort['docs'])) {
					$docs = get_posts([
						'post_type' => superdocs_post_type(),
						'orderby'   => 'post__in',
						'post__in'  => $categorySort['docs']
					]);
				}
				superdocs_category_content($productId, $category->ID, $docs);
			},
			'icon' => Common::moveIcon()
		]);
	} else {
		array_push($items, [
			'title' => esc_html__('Uncategorized', 'superdocs'),
			'content' => function() use($productId, $categorySort) {
				global $superDocsIds;
				$docs = get_posts([
					'post_type' => superdocs_post_type(),
					'exclude' => $superDocsIds, 
					'meta_query' => [
						[
							'key'     => 'superdocs_product',
							'compare' => 'NOT EXISTS'
						],
						[
							'key'     => 'superdocs_category',
							'compare' => 'NOT EXISTS'
						],
						[
							'key'     => 'productId',
							'value'   => $productId
						]
					]
				]);
				superdocs_category_content($productId, '0', $docs);
			},
			'icon' => Common::moveIcon()
		]);
	}
}

?>

<script>
  <?php View::render( 'admin/pages/category/sortjs', ['productId' => $productId] );?>
</script>
<!-- px-5 py-3 -->
<div class="rounded-xl p-7">

	<?php

	$accordion = new Accordion;
	$accordion->start( [
		'init'     => false,
		'position' => 'left',
		'multiple' => true,
		'classes'  => [
			'body'      => '',
			'tablist'   => '',
			'tabpanels' => 'bg-white',
			'inner'     => 'superdocs_product_' . $productId,
			'accordionHead' => 'bg-slate-100'
		]
	], $items );


	?>

	<div x-data="<?php wp_commander_render($categoryDataKey)?>">
		<div class="justify-between mb-10">
			<h4 class="text-[20px] font-bold font-primary text-heading mb-9 inline"><?php esc_html_e('Category List', 'superdocs')?></h4>
			<div class="float-right">
				<button x-on:click="createCategory($data)" class="cursor-pointer font-semibold rounded-md px-7 py-3 text-white items-center bg-primary hover:bg-primary-hover">
				+ <?php esc_html_e('Add Category', 'superdocs')?>
				</button>
			</div>
		</div>
	<?php $accordion->content(); ?>
	</div>
 	<?php $accordion->end(); ?>
</div>
<script>
	/**
	 * Create category
	 */
	Alpine.data('<?php wp_commander_render($categoryDataKey) ?>', () => ({
		createCategory($data) {
			var modal = Alpine.store('DoatKolomUiModal');
			modal.setContentByApi('<?php wp_commander_render(Utils::url_add_params(get_rest_url( null, 'superdocs/category/create' ), ['productId' => $productId]))?>', <?php wp_commander_render(json_encode($headers)); ?>, '<?php wp_commander_render( Common::generateRandomString() ); ?>');
			modal.pushData('getCategories', $data);
			modal.changeStatus();
		}
	}));

	/**
	 * Category Edit And Delete 
	 */
	Alpine.data('<?php wp_commander_render($categoryActionKey)?>', () => ({
		showCategoryDeleteAlert($data) {
			this.openCategoryActionModal($data, '/delete')
		},
		showCategoryEditAlert($data) {
			this.openCategoryActionModal($data, '/edit')
		},
		openCategoryActionModal($data, api) {
			var modal          = Alpine.store('DoatKolomUiModal');
			var categoryPostId = this.$el.dataset.categorypostid;
			var url            = new URL('<?php wp_commander_render( get_rest_url( null, 'superdocs/category' ) )?>' + api);
			url.searchParams.set('productId', '<?php wp_commander_render($productId) ?>');
			url.searchParams.set('categoryPostId', categoryPostId);
			modal.setContentByApi(url.toString(), <?php wp_commander_render( json_encode($headers) ); ?>);
			modal.pushData('getCategories', $data);
			modal.changeStatus();
		}
	}));

</script>
