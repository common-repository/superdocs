jQuery((function(t){t(".page-title-action").on("click",(function(t){t.preventDefault();var e=new URL(window.location.href),o=Alpine.store("DoatKolomUiModal");if(e.searchParams.has("product"))var a=SuperDocsSettings.root+"superdocs/product/create";else a=SuperDocsSettings.root+"superdocs/doc/create";o.setContentByApi(a,{headers:{"X-WP-Nonce":SuperDocsSettings.nonce}},"superDocsCreateDoc"),o.changeStatus()})),t("#the-list").on("click",".editinline",(function(){var e;if(void 0!==(e=t(this).closest("tr").find(".superdocs-template")).attr("data-template")){var o=JSON.parse(e.attr("data-template"));t('select[name="superdocs-template"] option[value="'+o.id+'"]').attr("selected","selected")}void 0!==(e=t(this).closest("tr").find(".superdocs-product")).attr("data-product")&&(o=JSON.parse(e.attr("data-product")),t('select[name="productId"] option[value="'+o.id+'"]').attr("selected","selected"))}))}));