<?php
namespace faqs;

if (!class_exists('\WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class FaqsCategoriesListTable extends \WP_List_Table
{
    private $items_per_page = 10;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'faq_category',
            'plural'   => 'faq_categories',
            'ajax'     => false,
        ]);
    }

    public function get_columns()
    {
        return [
            'cat_name'   => __('Category Name', 'faqs'),
            'created_at' => __('Created At', 'faqs'),
        ];
    }

    public function get_sortable_columns()
    {
        return [
            'cat_name'   => ['cat_name', false],
            'created_at' => ['created_at', true],
        ];
    }

    public function no_items()
    {
        esc_html_e('No categories found.', 'faqs');
    }

    public function prepare_items()
    {
        global $wpdb;

        $table   = $wpdb->prefix . 'faqs_categories';
        $search  = isset($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';
        $paged   = max(1, (int) $this->get_pagenum());
        $orderby = isset($_REQUEST['orderby']) ? sanitize_key(wp_unslash($_REQUEST['orderby'])) : 'created_at';
        $order   = isset($_REQUEST['order']) ? strtoupper(sanitize_text_field(wp_unslash($_REQUEST['order']))) : 'DESC';

        if (!in_array($orderby, ['cat_name', 'created_at'], true)) {
            $orderby = 'created_at';
        }
        if (!in_array($order, ['ASC', 'DESC'], true)) {
            $order = 'DESC';
        }

        $where       = ' WHERE 1=1 ';
        $where_params = [];
        if ('' !== $search) {
            $where .= ' AND cat_name LIKE %s ';
            $where_params[] = '%' . $wpdb->esc_like($search) . '%';
        }

        $total_sql = "SELECT COUNT(*) FROM {$table}{$where}";
        $total_items = $where_params ? (int) $wpdb->get_var($wpdb->prepare($total_sql, $where_params)) : (int) $wpdb->get_var($total_sql);

        $offset = ($paged - 1) * $this->items_per_page;
        $sql = "SELECT cat_name, created_at FROM {$table}{$where} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d";
        $params = array_merge($where_params, [$this->items_per_page, $offset]);
        $this->items = $wpdb->get_results($wpdb->prepare($sql, $params), ARRAY_A);

        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];
        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $this->items_per_page,
            'total_pages' => (int) ceil($total_items / $this->items_per_page),
        ]);
    }

    public function column_default($item, $column_name)
    {
        if ('created_at' === $column_name) {
            $timestamp = strtotime((string) $item[$column_name]);
            return $timestamp ? esc_html(wp_date(get_option('date_format') . ' ' . get_option('time_format'), $timestamp)) : esc_html($item[$column_name]);
        }

        return isset($item[$column_name]) ? esc_html($item[$column_name]) : '';
    }
}
