<?php

defined( 'ABSPATH' ) || exit;

trait VS_BQP_Admin_UI {
    public function render_bulk_modal() {
        $screen = get_current_screen();
        if ( ! $screen || 'product' !== $screen->post_type ) return;
        ?>
        <div id="vs-bqp-bulk-modal" class="vs-bqp-modal" hidden aria-hidden="true">
            <div class="vs-bqp-modal__backdrop" data-vs-bqp-close></div>
            <div class="vs-bqp-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="vs-bqp-bulk-title">
                <div class="vs-bqp-modal__header">
                    <h2 id="vs-bqp-bulk-title"><?php esc_html_e( 'Set Units Per Box', 'vs-box-quantity-pricing' ); ?></h2>
                    <button type="button" class="vs-bqp-modal__close" data-vs-bqp-close aria-label="<?php esc_attr_e( 'Close', 'vs-box-quantity-pricing' ); ?>">&times;</button>
                </div>
                <div class="vs-bqp-modal__body">
                    <label for="vs-bqp-bulk-units"><?php esc_html_e( 'Units Per Box', 'vs-box-quantity-pricing' ); ?></label>
                    <input type="number" id="vs-bqp-bulk-units" min="1" step="1" inputmode="numeric">
                    <p><?php esc_html_e( 'Apply one box quantity to every variation of this product. Enter 1 to disable box pricing on all variations.', 'vs-box-quantity-pricing' ); ?></p>
                    <p id="vs-bqp-bulk-status" class="vs-bqp-modal__status" role="status" aria-live="polite"></p>
                </div>
                <div class="vs-bqp-modal__footer">
                    <button type="button" class="button-link" data-vs-bqp-inherit><?php esc_html_e( 'Use parent setting', 'vs-box-quantity-pricing' ); ?></button>
                    <button type="button" class="button" data-vs-bqp-close><?php esc_html_e( 'Cancel', 'vs-box-quantity-pricing' ); ?></button>
                    <button type="button" class="button button-primary" id="vs-bqp-bulk-apply"><?php esc_html_e( 'Apply to all variations', 'vs-box-quantity-pricing' ); ?></button>
                </div>
            </div>
        </div>
        <?php
    }
}
