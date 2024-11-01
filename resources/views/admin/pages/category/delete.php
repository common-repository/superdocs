<?php

use DoatKolom\Ui\Utils\Common;

$dataKey             = Common::generateRandomString(10);
$categoryParentClass = 'superdocs_product_' . $productId;

?>

<div class="p-7" x-data="<?php wp_commander_render($dataKey) ?>">
    <h2 class="line-clamp-1 dark:text-navy-100 text-xl font-bold tracking-wide text-slate-700 lg:text-base">
        <?php esc_html_e('Are you sure to delete this category?', 'superdocs') ?>
    </h2>
    <div class="mt-4">
        <p class="text-danger">
            <strong class="text-base">All Documents</strong> in this category will be <strong class="text-base">Deleted along</strong> with the category. If you don't want to delete those documents then rename the category or move the documents to another category
        </p>
    </div>
    <div class="mt-4">
        <button 
            x-on:click="deleteCategory()" 
            :class="(sendCategoryDeleteRequestStatus ? 'pointer-events-none' : '')" 
            class="inline-flex cursor-pointer font-semibold rounded-md px-7 py-3 text-white items-center bg-danger hover:bg-danger-hover">
            <svg x-show="sendCategoryDeleteRequestStatus" class="animate-spin -ml-1 mr-3 h-5 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <?php esc_html_e('Delete', 'superdocs') ?>
        </button>
        <button x-on:click="cancelCategory()" x-show="!sendCategoryDeleteRequestStatus" class="cursor-pointer font-semibold rounded-md px-7 py-3 items-center border border-gray-200 bg-white hover:bg-gray-50">
            <?php esc_html_e('Cancel', 'superdocs') ?>
        </button>
    </div>
</div>
<script>
    Alpine.data('<?php wp_commander_render($dataKey) ?>', () => ({
        sendCategoryDeleteRequestStatus: false,
        deleteCategory() {
            this.sendCategoryDeleteRequestStatus = true;
            var modal = Alpine.store('DoatKolomUiModal');
            modal.lock();
            let docs = [];
            let categoryContent = document.querySelector('[data-category="<?php wp_commander_render($categoryPostId) ?>"]');
            for (let doc of categoryContent.children) {
                docs.push(doc.dataset.doc);
            }
            let alpineData = this;
            jQuery.ajax({
                url: "<?php wp_commander_render(get_rest_url(null, 'superdocs/category/delete')) ?>",
                method: 'POST',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', "<?php wp_commander_render(wp_create_nonce('wp_rest')) ?>");
                },
                data: {
                    docs,
                    productId: '<?php wp_commander_render($productId) ?>',
                    categoryPostId: '<?php wp_commander_render($categoryPostId) ?>'
                },
                success: function(data) {
                    let ChildNo = DoatKolomUiUtils.getChildNo(categoryContent.closest('.accordionItem'), categoryContent.closest('.<?php wp_commander_render($categoryParentClass) ?>'));
                    delete modal.getCategories.accordions[ChildNo - 1];
                    alpineData.$dispatch('notify', {
                        content: data.message,
                        type: 'success'
                    })
                    modal.changeStatus(true)
                }
            })
        },
        cancelCategory() {
            var modal = Alpine.store('DoatKolomUiModal');
            modal.changeStatus()
        }
    }))
</script>