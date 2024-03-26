<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

// @phpcs:disable PSR1.Files.SideEffects
// @phpcs:disable PSR12.Files.FileHeader
// @phpcs:disable Generic.Files.InlineHTML
// @phpcs:disable Generic.Files.LineLength

/**
 * Plugin Name: Forminator - CryptoPay Gateway
 * Version:     1.0.0
 * Plugin URI:  https://beycanpress.com/cryptopay/
 * Description: Adds Cryptocurrency payment gateway (CryptoPay) for Forminator.
 * Author:      BeycanPress LLC
 * Author URI:  https://beycanpress.com
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: forminator-cryptopay
 * Tags: Cryptopay, Cryptocurrency, WooCommerce, WordPress, MetaMask, Trust, Binance, Wallet, Ethereum, Bitcoin, Binance smart chain, Payment, Plugin, Gateway, Moralis, Converter, API, coin market cap, CMC
 * Requires at least: 5.0
 * Tested up to: 6.4.3
 * Requires PHP: 8.1
*/

// Autoload
require_once __DIR__ . '/vendor/autoload.php';

define('FORMINATOR_CRYPTOPAY_FILE', __FILE__);
define('FORMINATOR_CRYPTOPAY_VERSION', '1.0.0');
define('FORMINATOR_CRYPTOPAY_KEY', basename(__DIR__));
define('FORMINATOR_CRYPTOPAY_URL', plugin_dir_url(__FILE__));
define('FORMINATOR_CRYPTOPAY_DIR', plugin_dir_path(__FILE__));
define('FORMINATOR_CRYPTOPAY_SLUG', plugin_basename(__FILE__));

use BeycanPress\CryptoPay\Integrator\Helpers;

Helpers::registerModel(BeycanPress\CryptoPay\Forminator\Models\TransactionsPro::class);
Helpers::registerLiteModel(BeycanPress\CryptoPay\Forminator\Models\TransactionsLite::class);

load_plugin_textdomain('forminator-cryptopay', false, basename(__DIR__) . '/languages');

add_action('plugins_loaded', function (): void {
    if (!defined('FORMINATOR_PLUGIN_BASENAME')) {
        Helpers::requirePluginMessage('Forminator', 'https://wordpress.org/plugins/forminator/');
    } elseif (Helpers::bothExists()) {
        new BeycanPress\CryptoPay\Forminator\Loader();
    } else {
        Helpers::requireCryptoPayMessage('Forminator');
    }
});
