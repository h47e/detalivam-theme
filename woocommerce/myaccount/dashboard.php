<?php
defined( 'ABSPATH' ) || exit;
$customer = wp_get_current_user();
$account_tasks = array(
    'orders'       => array( 'Заказы', 'История заказов и их статус' ),
    'edit-address' => array( 'Адреса', 'Адреса доставки и получателя' ),
    'edit-account' => array( 'Мои данные', 'Имя, email и пароль' ),
);
?>
<div class="dv-account-overview">
    <h2><?php echo esc_html( sprintf( 'Здравствуйте, %s', $customer->display_name ) ); ?></h2>
    <div class="dv-account-tasks">
        <?php foreach ( $account_tasks as $endpoint => $task ) : ?>
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                <strong><?php echo esc_html( $task[0] ); ?></strong>
                <span><?php echo esc_html( $task[1] ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php do_action( 'woocommerce_account_dashboard' ); ?>
