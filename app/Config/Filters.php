<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PermitAll;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter; // Pastikan ini ada dan benar

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things a little nicer and simpler.
     *
     * @var array<string, array<string, string>>
     * @phpstan-var array<string, class-string<\CodeIgniter\Filters\FilterInterface>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'permits'       => PermitAll::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => AuthFilter::class, // Pastikan alias 'auth' ini ada dan menunjuk ke AuthFilter::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf', // Pastikan ini tidak dikomentari
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array<string, array<string, string>>
     * @phpstan-var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * specific routes, not necessarily all or every HTTP method.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#applying-filters-to-specific-routes
     *
     * @var array<string, array<string, string>>
     * @phpstan-var array<string, list<string>>
     */
    public array $filters = [];
}
