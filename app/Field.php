<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Forminator;

// phpcs:disable PSR1.Methods.CamelCapsMethodName
// phpcs:disable Squiz.NamingConventions.ValidVariableName
// phpcs:disable PSR2.Classes.PropertyDeclaration.Underscore
// phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint
// phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint

class Field extends \Forminator_Field
{
    /**
     * @var string
     */
    public $name = 'CryptoPay';

    /**
     * @var string
     */
    public $slug = 'cryptopay';

    /**
     * @var string
     */
    public $type = 'cryptopay';

    /**
     * @var int
     */
    public $position = 24;

    /**
     * @var array<mixed>
     */
    public $options = [];

    /**
     * @var string
     */
    public $category = 'standard';

    /**
     * @var string
     */
    public $icon = 'sui-icon cryptopay-icon';

    /**
     * @var array<mixed>
     */
    public $field;

    /**
     * @var array<mixed>
     */
    public $form_settings;


    /**
     * Gateway constructor.
     */
    public function __construct()
    {
        parent::__construct();
        add_action('admin_enqueue_scripts', [$this, 'adminScripts']);
    }

    /**
     * @return void
     */
    public function adminScripts(): void
    {
        wp_enqueue_style(
            'forminator-cryptopay',
            FORMINATOR_CRYPTOPAY_URL . 'assets/css/main.css',
            [],
            FORMINATOR_CRYPTOPAY_VERSION
        );

        wp_enqueue_script(
            'forminator-cryptopay',
            FORMINATOR_CRYPTOPAY_URL . 'assets/js/admin.js',
            [],
            FORMINATOR_CRYPTOPAY_VERSION,
            true
        );
    }

    /**
     * @return array<mixed>
     */
    public function defaults(): array
    {
        $currency = 'USD';
        try {
            // gateway
        } catch (\Exception $e) {
            forminator_maybe_log(__METHOD__, $e->getMessage());
        }

        return [
            'currency'    => $currency,
            'amount_type' => 'fixed',
            'options'     => []
        ];
    }

    /**
     * Front-end markup
     * @param array<mixed> $field
     * @param \Forminator_Render_Form $views_obj Forminator_Render_Form object.
     * @return string
     */
    public function markup($field, $views_obj): string
    {

        $this->field         = $field;
        $this->form_settings = $views_obj->model->settings;

        $elementName    = self::get_property('element_id', $field);
        $fieldId        = $elementName . '-field';
        $amount         = self::get_property('amount', $field, '0');
        $amountVariable = self::get_property('variable', $field, '');
        $amountType     = self::get_property('amount_type', $field, 'fixed');
        $currency       = self::get_property('currency', $field, $this->getDefaultCurrency());

        $attr = [
            'type'              => 'hidden',
            'name'              => $elementName,
            'id'                => 'forminator-' . $fieldId,
            'class'             => 'forminator-cryptopay-input',
            'data-is-payment'   => 'true',
            'data-payment-type' => $this->type,
            'data-amount-type'  => esc_html($amountType),
            'data-currency'     => esc_html(strtolower($currency)),
            'data-amount'       => ('fixed' === $amountType ? esc_html($amount) : $amountVariable),
        ];

        $html = self::create_input($attr);

        return apply_filters('forminator_field_cryptopay_markup', $html, $attr, $field);
    }

    /**
     * @return string
     */
    public function getDefaultCurrency(): string
    {
        return 'USD';
    }
}
