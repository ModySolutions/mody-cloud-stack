<?php
/*
 * Plugin Name: Mody Invoice
 * Plugin URI: https://mody.cloud
 * Description: Invoice module for Mody Cloud.
 * Author: Mody Cloud
 * Version: 0.0.1
 * Author URI: https://mody.cloud
 */

namespace Mody\Invoice;

const INVOICE_POST_TYPE_NAME   = 'invoice';
const INVOICE_POST_STATUS_NAME = 'invoice-status';

require_once __DIR__ . '/includes/cpt.php';
require_once __DIR__ . '/includes/acf-options.php';
