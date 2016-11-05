<?php
/**
 * Plugin Name: AUSteve Icebreaker plugin
 * Plugin URI: https://github.com/australiansteve/wp-plugin-austeve-icebreaker
 * Description: Calgary IceBreaker website plugin
 * Version: 1.0.0
 * Author: AustralianSteve
 * Author URI: http://AustralianSteve.com
 * License: GPL2
 */

/**
 * Custom Form Fields
 * 
 * @param $form_id
 */
function austeve_give_custom_form_fields( $form_id ) {

    ?>
    <div id="give-dipster-donation">
        <input type="hidden" id="user_donation" name="user_donation" value=""/>
    </div>
    <?php
}

add_action( 'give_after_donation_levels', 'austeve_give_custom_form_fields', 10, 1 );

/**
 * Validate Custom Field
 *
 * @description check for errors without custom fields
 *
 * @param $valid_data
 * @param $data
 */
function austeve_give_validate_custom_fields( $valid_data, $data ) {

    //Check for a valid user donation data
    if ( intval( $data['user_donation'] ) < 0 ) {
        give_set_error( 'user_donation', __( 'Please don\'t mess with the fields', 'give' ) );
    }
    
}

add_action( 'give_checkout_error_checks', 'austeve_give_validate_custom_fields', 10, 2 );

/**
 * Add Field to Payment Meta
 *
 * @description store the custom field data in the payment meta
 *
 * @param $payment_meta
 *
 * @return mixed
 */
function austeve_give_store_custom_fields( $payment_meta ) {
    $payment_meta['user_donation'] = isset( $_POST['user_donation'] ) ? implode( "n", array_map( 'sanitize_text_field', explode( "n", intval( $_POST['user_donation'] ) ) ) ) : '';

    return $payment_meta;
}

add_filter( 'give_payment_meta', 'austeve_give_store_custom_fields' );

/**
 * Show Data in Transaction Details
 *
 * @description show the custom field(s) on the transaction page
 *
 * @param $payment_meta
 * @param $user_info
 */
function austeve_give_donation_details( $payment_id ) {

    //uncomment below to see payment_meta array
    //echo "<pre>";
    //  var_dump($payment_meta);
    //  echo "</pre>";

    //Bounce out if no data for this transaction
    //if ( ! isset( $payment_meta['user_donation'] ) ) {
    //    return;
    //}
    $payment_meta = give_get_payment_meta( $payment_id );

    $args = array(
        'show_option_none' => 'N/A',
        'selected' => $payment_meta['user_donation'],
        'name' => 'donation_to_user',
        'id' => 'donation_to_user',
        'class' => 'disabled'
    );

    ?>
    <td class="donation-to">
        <?php wp_dropdown_users( $args );  ?>
    </td>
<?php
}

add_action( 'give_donation_details_tbody_after', 'austeve_give_donation_details', 10, 2 );


function austeve_give_donation_details_header( $payment_meta ) {

    ?>
    <th><?php esc_html_e( 'Donation To', 'give' ) ?></th>
    <?php
}

add_action( 'give_donation_details_thead_after', 'austeve_give_donation_details_header', 10, 2 );

?>