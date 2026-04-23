<?php
    namespace faqs;

    if (! class_exists('\WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
    }

    class FaqsListTable extends \WP_List_Table
    {
    private $order;
    private $orderby;
    private $search         = '';
    private $items_per_page = 10;

    public function __construct()
    {
        parent::__construct([
            'singular' => 'faq',
            'plural'   => 'faqs',
            'ajax'     => true,
        ]);

        $this->set_order();
        $this->set_orderby();
        $this->set_search();
    }

    private function get_sql_results()
    {
        global $wpdb;

        $faqs_details = $wpdb->prefix . 'faqs_details';

        $args = ['id', 'name', 'icon'];

        $sql_select = implode(', ', $args);

        $query = "SELECT $sql_select FROM $faqs_details WHERE status = 1";
        if ($this->search !== '') {
            $query .= $wpdb->prepare(' AND name LIKE %s', '%' . $wpdb->esc_like($this->search) . '%');
        }
        $query .= " ORDER BY $this->orderby $this->order";

        $sql_results = $wpdb->get_results($query);

        return $sql_results;
    }

    public function set_order()
    {
        $order       = (isset($_GET['order']) && $_GET['order']) ? strtoupper(sanitize_text_field(wp_unslash($_GET['order']))) : 'ASC';
        $this->order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'ASC';
    }

    public function set_orderby()
    {
        $orderby       = (isset($_GET['orderby']) && $_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'created_at';
        $allowed       = ['id', 'name', 'created_at'];
        $this->orderby = in_array($orderby, $allowed, true) ? $orderby : 'created_at';
    }

    public function set_search()
    {
        $this->search = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
    }

    /**
     * @see WP_List_Table::ajax_user_can()
     */
    public function ajax_user_can()
    {
        return current_user_can('edit_posts');
    }

    /**
     * @see WP_List_Table::no_items()
     */
    public function no_items()
    {
        _e('No Faqs found.');
    }

    /**
     * @see WP_List_Table::get_views()
     */
    public function get_views()
    {
        return [];
    }

    /**
     * @see WP_List_Table::get_columns()
     */
    public function get_columns()
    {
        $columns = [
            'id'       => __('ID'),
            'name'     => __('Name'),
            //'icon'       => __( 'Icon' ),
            'function' => __('Function'),
            'actions'  => __('Actions'),
        ];

        return $columns;
    }

    /**
     * @see WP_List_Table::get_sortable_columns()
     */
    public function get_sortable_columns()
    {
        $sortable = [
            'id'   => ['id', true],
            'name' => ['name', true],
        ];

        return $sortable;
    }

    public function get_hidden_columns()
    {
        $hidden = [];

        return $hidden;
    }

    /**
     * Prepare data for display
     * @see WP_List_Table::prepare_items()
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        // SQL results
        $posts = $this->get_sql_results();

        empty($posts) and $posts = [];

        # >>>> Pagination
        $per_page = $this->items_per_page;

        $current_page = $this->get_pagenum();

        $total_items = count($posts);

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);

        $last_post                               = $current_page * $per_page;
        $first_post                              = $last_post - $per_page + 1;
        $last_post > $total_items and $last_post = $total_items;

        // Setup the range of keys/indizes that contain
        // the posts on the currently displayed page(d).
        // Flip keys with values as the range outputs the range in the values.
        $range = array_flip(range($first_post - 1, $last_post - 1, 1));

        // Filter out the posts we're not displaying on the current page.
        $posts_array = array_intersect_key($posts, $range);
        # <<<< Pagination

        $processData = $this->process_items($posts_array);

        $this->items = $processData;
    }

    /**
     * A single column
     */
    public function column_default($item, $column_name)
    {
        return $item->$column_name;
    }

    /**
     * Override of table nav to avoid breaking with bulk actions & according nonce field
     */
    public function display_tablenav($which)
    {
        ?>
        <div class="tablenav <?php echo esc_attr($which); ?>">
            <!--
            <div class="alignleft actions">
                <?php # $this->bulk_actions( $which ); ?>
            </div>
             -->
            <?php
                $this->extra_tablenav($which);
                        $this->pagination($which);
                    ?>
            <br class="clear" />
        </div>
        <?php
            }

                /**
                 * Disables the views for 'side' context as there's not enough free space in the UI
                 * Only displays them on screen/browser refresh. Else we'd have to do this via an AJAX DB update.
                 *
                 * @see WP_List_Table::extra_tablenav()
                 */
                public function extra_tablenav($which)
                {
                    global $wp_meta_boxes;
                    $views = $this->get_views();
                    if (empty($views)) {
                        return;
                    }

                    $this->views();
                }

                public function process_items($items)
                {
                    $process_items = [];

                    foreach ($items as $key => $item) {
                        $item->name = '<a href="' . admin_url('admin.php?page=faqs-view-faqs&faqsid=' . $item->id) . '">' . $item->name . '</a>';

                        $item->function = '';
                        if (function_exists('faqs_getAll')) {
                            ob_start();
                            faqs_getAll((int) $item->id, ['accordion' => true]);
                            $item->function = ob_get_clean();
                        }

                        $item->actions = '<span class="faqs-actions"><a href="' . admin_url('admin.php?page=faqs-edit-faq&faqsid=' . $item->id) . '">Edit</a><span style="color:#8c8f94; margin:0 8px;">|</span><a href="#" class="faqs-delete-faq" data-faqsid="' . (int) $item->id . '" data-nonce="' . esc_attr(wp_create_nonce('faqs_delete_' . (int) $item->id)) . '">Delete</a></span>';

                        $process_items[$key] = $item;
                    }

                    return $process_items;
                }
        }
        ?>