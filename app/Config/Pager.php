<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     *
     * @var int
     */
    public int $perPage = 10; // Mengatur default perPage ke 10

    /**
     * --------------------------------------------------------------------------
     * Templates
     * --------------------------------------------------------------------------
     *
     * Pagination links are rendered using default templates to store links.
     *
     * You may customize these by adding your own templates to this array.
     *
     * You can also set a default template in the `$default` property.
     */
    public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        // Ubah baris ini untuk menunjuk ke template kustom Anda
        'bootstrap_full' => 'App\Views\Pagers\bootstrap_full', // Pastikan ini 'App\Views\Pagers\bootstrap_full'
        'bootstrap_simple' => 'CodeIgniter\Pager\Views\bootstrap_simple',
    ];

    /**
     * --------------------------------------------------------------------------
     * Default Template
     * --------------------------------------------------------------------------
     *
     * The default pagination template to use.
     *
     * @var string
     */
    public string $default = 'bootstrap_full';
}
