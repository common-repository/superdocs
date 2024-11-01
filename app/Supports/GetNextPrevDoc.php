<?php

namespace SuperDocs\App\Supports;

class GetNextPrevDoc
{
    public $categories;
    public $currentCategoryDocs;
    public $nextDoc;
    public $prevDoc;

    public function get( $docId, $productId, $categoryId )
    {
        $this->categories = superdocs_get_ordered_category_list( $productId );

		/**
		 * remove unCategorized docs
		 */
        $unCategorizedKey = array_search( '0', array_column( $this->categories, 'categoryPostId' ) );
		unset($this->categories[$unCategorizedKey]);
		$this->categories = array_values($this->categories);

        $categoryKey      = array_search( $categoryId, array_column( $this->categories, 'categoryPostId' ) );

        if ( is_int( $categoryKey ) ) {
            $this->currentCategoryDocs = $this->categories[$categoryKey]['docs'];
            $docKey                    = array_search( $docId, $this->currentCategoryDocs );
            if ( is_int( $docKey ) ) {

                /**
                 * Get next link
                 */
                $nextDocKey      = $docKey + 1;
                $nextCategoryKey = $categoryKey + 1;
                $this->nextDoc   = $this->getNextDoc( $nextDocKey, $nextCategoryKey );

                $this->currentCategoryDocs = $this->categories[$categoryKey]['docs'];
                $prevDocKey                = $docKey - 1;
                $prevCategoryKey           = $categoryKey - 1;
                $this->prevDoc             = $this->getPrevDoc( $prevDocKey, $prevCategoryKey );
            }
        }

        return ['next' => $this->nextDoc, 'prev' => $this->prevDoc];
    }

    public function getPrevDoc( $prevDocKey, $prevCategoryKey )
    {
        /**
         * get form docs list
         */
        if ( isset( $this->currentCategoryDocs[$prevDocKey] ) ) {
            $prevDocId = $this->currentCategoryDocs[$prevDocKey];
            $prevDoc   = get_post( $prevDocId );

            /**
             * if found prev then just doing return;
             */
            if ( $prevDoc && 'publish' === $prevDoc->post_status ) {
                return $prevDoc;
            }

            /**
             * check this docs is category last item
             */
            if (  ( $prevDocKey - 1 ) < 0 ) {
                return $this->goPrevCategory( $prevCategoryKey );
            } else {
                return $this->getPrevDoc( $prevDocKey, $prevCategoryKey );
            }
        } else {
            return $this->goPrevCategory( $prevCategoryKey );
        }

        return false;
    }

    public function goPrevCategory( $prevCategoryKey )
    {
        if ( empty( $this->categories[$prevCategoryKey]['docs'] ) ) {
            $prevCategoryKey = $prevCategoryKey - 1;
            if ( $prevCategoryKey > -1 ) {
                if ( isset( $this->categories[$prevCategoryKey]['docs'] ) ) {
                    $this->currentCategoryDocs = $this->categories[$prevCategoryKey]['docs'];
                } else {
                    $this->currentCategoryDocs = [];
                }
                return $this->getPrevDoc( count( $this->currentCategoryDocs ) - 1, $prevCategoryKey );
            }
        } else {
            $this->currentCategoryDocs = $this->categories[$prevCategoryKey]['docs'];
            return $this->getPrevDoc( count( $this->currentCategoryDocs ) - 1, $prevCategoryKey );
        }

        return false;
    }

    public function getNextDoc( $nextDocKey, $nextCategoryKey )
    {
        /**
         * get form docs list
         */
        if ( isset( $this->currentCategoryDocs[$nextDocKey] ) ) {
            $nextDocId = $this->currentCategoryDocs[$nextDocKey];
            $nextDoc   = get_post( $nextDocId );

            /**
             * if found next then just doing return;
             */
            if ( $nextDoc && 'publish' === $nextDoc->post_status ) {
                return $nextDoc;
            }

            /**
             * check this docs is category last item
             */
            if (  ( $nextDocKey + 1 ) === count( $this->currentCategoryDocs ) ) {
                return $this->goNextCategory( $nextCategoryKey );
            } else {
                return $this->getNextDoc( $nextDocKey, $nextCategoryKey );
            }
        } else {
            return $this->goNextCategory( $nextCategoryKey );
        }

        return false;
    }

    public function goNextCategory( $nextCategoryKey )
    {
        if ( empty( $this->categories[$nextCategoryKey]['docs'] ) ) {
            if ( $nextCategoryKey <= count( $this->categories ) - 1 ) {
                $nextCategoryKey = $nextCategoryKey + 1;
                if ( empty( $this->categories[$nextCategoryKey]['docs'] ) ) {
                    $this->currentCategoryDocs = [];
                } else {
                    $this->currentCategoryDocs = $this->categories[$nextCategoryKey]['docs'];
                }
                return $this->getNextDoc( 0, $nextCategoryKey );
            }
        } else {
            $this->currentCategoryDocs = $this->categories[$nextCategoryKey]['docs'];
            return $this->getNextDoc( 0, $nextCategoryKey );
        }
        return false;
    }
}
