<?php

use App\Models\Comms;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

/* Predefined Messages */

define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 10);
define('USER_ROLES', [
    'nfp-admin',
    'client-admin',
    'legal-admin',
    'lawyer'
]);

define('USER_ROLES_LAWER', [
    'legal-admin',
    'lawyer'
]);

/**
 * Template configaration classes.
 *
 * @return array
 */
function applClasses()
{
    // default data array
    $data = [
        'myLayout'            => 'horizontal',
        // horizontal, vertical
        'myTheme'             => 'theme-default',
        'myStyle'             => 'light',
        'myRTLSupport'        => true,
        'myRTLMode'           => false,
        'hasCustomizer'       => true,
        'showDropdownOnHover' => true,
        'displayCustomizer'   => true,
        'menuFixed'           => true,
        'menuCollapsed'       => false,
        'navbarFixed'         => true,
        'footerFixed'         => false,
        'menuFlipped'         => false,
        'customizerControls'  => [
            'rtl',
            'style',
            'layoutType',
            'showDropdownOnHover',
            'layoutNavbarFixed',
            'layoutFooterFixed',
            'themes',
        ],

        'mainLayoutType'    => 'horizontal',
        // horizontal, vertical, blank
        'bodyClass'         => '',
        'dataTemplateClass' => '',
        'defaultLanguage'   => 'en',
        'direction'         => 'ltr',
        'blankPage'         => false,
    ];

    if (request()->is('pos/sales/*') || request()->is('pos/sales')) {
        $data['mainLayoutType'] = 'blank';
        $data['blankPage']      = true;
    }

    // All options available in the template
    $allOptions = [
        // 'mainLayoutType' => ['vertical', 'horizontal', 'blank'],
        // 'bodyClass' => ['vertical' => 'layout-navbar-fixed layout-menu-fixed', 'horizontal' => ''],
        // 'dataTemplateClass' => ['vertical' => 'vertical-menu-template', 'horizontal' => 'horizontal-menu-template'],
        // 'defaultLanguage' => ['en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'],
        // 'direction' => ['ltr', 'rtl'],

        'myLayout'            => [
            'vertical',
            'horizontal',
            'blank'
        ],
        'menuCollapsed'       => [
            true,
            false
        ],
        'hasCustomizer'       => [
            true,
            false
        ],
        'showDropdownOnHover' => [
            true,
            false
        ],
        'displayCustomizer'   => [
            true,
            false
        ],
        'myStyle'             => [
            'light',
            'dark'
        ],
        'myTheme'             => [
            'theme-default',
            'theme-bordered',
            'theme-semi-dark'
        ],
        'myRTLSupport'        => [
            true,
            false
        ],
        'myRTLMode'           => [
            true,
            false
        ],
        'menuFixed'           => [
            true,
            false
        ],
        'navbarFixed'         => [
            true,
            false
        ],
        'footerFixed'         => [
            true,
            false
        ],
        'menuFlipped'         => [
            true,
            false
        ],
        // 'menuOffcanvas' => [true, false],
        'customizerControls'  => [],
    ];

    //layout classes
    $layoutClasses = [
        'bodyClass'         => $data['bodyClass'],
        'dataTemplateClass' => $data['dataTemplateClass'],
        'blankPage'         => $data['blankPage'],
        'blankPageClass'    => '',
        'mainLayoutType'    => $data['mainLayoutType'],
        'defaultLanguage'   => $data['defaultLanguage'],
        'direction'         => $data['direction'],

        'layout'              => $data['myLayout'],
        'theme'               => $data['myTheme'],
        'style'               => $data['myStyle'],
        'rtlSupport'          => $data['myRTLSupport'],
        'rtlMode'             => $data['myRTLMode'],
        'textDirection'       => $data['myRTLMode'],
        'menuCollapsed'       => $data['menuCollapsed'],
        'hasCustomizer'       => $data['hasCustomizer'],
        'showDropdownOnHover' => $data['showDropdownOnHover'],
        'displayCustomizer'   => $data['displayCustomizer'],
        'menuFixed'           => $data['menuFixed'],
        'navbarFixed'         => $data['navbarFixed'],
        'footerFixed'         => $data['footerFixed'],
        'menuFlipped'         => $data['menuFlipped'],
        // 'menuOffcanvas' => $data['menuOffcanvas'],
        'customizerControls'  => $data['customizerControls'],
    ];
    // set default language if session hasn't locale value the set default language
    if (!session()->has('locale')) {
        app()->setLocale($layoutClasses['defaultLanguage']);
    }

    // blank page class
    if ($layoutClasses['blankPage'] != 'true') {
        //$layoutClasses['bodyClass'] = $allOptions['bodyClass'][$layoutClasses['mainLayoutType']];
        //$layoutClasses['dataTemplateClass'] = $allOptions['dataTemplateClass'][$layoutClasses['mainLayoutType']];
    }

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
        $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
        $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }

    // Navbar Fixed
    if ($layoutClasses['navbarFixed'] == true) {
        $layoutClasses['navbarFixed'] = 'layout-navbar-fixed';
    }

    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
        $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // Menu Flipped
    if ($layoutClasses['menuFlipped'] == true) {
        $layoutClasses['menuFlipped'] = 'layout-menu-flipped';
    }

    // Menu Offcanvas
    // if ($layoutClasses['menuOffcanvas'] == true) {
    //   $layoutClasses['menuOffcanvas'] = 'layout-menu-offcanvas';
    // }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
        $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
        $layoutClasses['rtlMode']       = 'rtl';
        $layoutClasses['textDirection'] = 'rtl';
    } else {
        $layoutClasses['rtlMode']       = 'ltr';
        $layoutClasses['textDirection'] = 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
        $layoutClasses['showDropdownOnHover'] = 'true';
    } else {
        $layoutClasses['showDropdownOnHover'] = 'false';
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
        $layoutClasses['displayCustomizer'] = 'true';
    } else {
        $layoutClasses['displayCustomizer'] = 'false';
    }

    return $layoutClasses;
}

/**
 * Remove slash http(s) from given url.
 *
 * @param string $url
 * @return string
 */
if (!function_exists('urlToStr')) {
    function urlToStr($url)
    {
        return preg_replace('#^[^:/.]*[:/]+#i', '', preg_replace('{/$}', '', config('app.url')));
    }
}

/**
 * Check current url with route.
 *
 * @param string $route
 * @param string $output
 * @return string
 */
if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routes, $output = 'active')
    {
        if (is_string($routes)) {
            return (Route::currentRouteName() == $routes) ? $output : '';
        }

        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
    }
}

/**
 * Remove spaces from string.
 *
 * @param string $str
 * @param string $repBy
 * @return string
 */
if (!function_exists('removeSpace')) {
    function removeSpace($str, $repBy = '')
    {
        return empty($str) ? null : preg_replace('/\s+/', $repBy, $str);
    }
}

/**
 * Auto gen unique 5 digit number - starting from 01001
 */
if (!function_exists('incrReqNo')) {
    function incrReqNo($num)
    {
        if (!$num) {
            return '01001';
        }
        return str_pad($num + 1, 5, 0, STR_PAD_LEFT);
    }
}

/**
 * Convert datetime to human readable format.
 *
 * @param date $date
 * @param string $format
 * @param string $repBy
 * @param date
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'l, d F Y', $repBy = null)
    {
        if (!empty($date) && !empty($repBy)) {
            $date = str_replace('/', $repBy, $date);
        }
        $date = Carbon::create($date);
        return $date ? date($format, strtotime($date->setTimezone(Config::get('app.timezone')))) : null;
    }
}

/**
 * Flash message with label.
 *
 * @param string $message
 * @param string $level
 * @return void
 */
if (!function_exists('flash')) {
    function flash($message, $level = 'success', $important = false)
    {
        session()->flash('flash_message', $message);
        session()->flash('flash_message_level', $level);
        session()->flash('flash_important', $important);
    }
}

/**
 * Common json success response.
 *
 * @param string $message
 * @param int $code
 * @param bool $status
 * @return josn
 */
if (!function_exists('respond')) {
    function respond($message, $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Common json error response.
 *
 * @param string $message
 * @param int $code
 * @param bool $status
 * @return josn
 */
if (!function_exists('respondError')) {
    function respondError($message, $code = 500, $status = false)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Checked super admin has impersonate.
 *
 * @return bool
 */
if (!function_exists('isSuperAdminImpersonate')) {
    function isSuperAdminImpersonate()
    {
        return session()->has('IS_IMPERSONATE') ? true : null;
    }
}

/**
 * Return short string.
 *
 * @return bool
 */
if (!function_exists('shortString')) {
    function shortString($string, $delimiter = ' ')
    {
        $strArr = explode($delimiter, trim($string));
        $length = count($strArr);

        if ($length > 1) {
            return $strArr[0][0] . $strArr[$length - 1][0];
        }

        return substr($string, 0, 2);
    }
}

/**
 * Return post type.
 *
 * @return bool
 */
if (!function_exists('postTypes')) {
    function postTypes()
    {
        return [
            'looking' => 'We are searching',
            'offer'   => 'We are offering',
        ];
    }
}

function messageCount() {
    $count = Comms::query()->where(function ($q) {
        $q->where('to_org_id', authUserOrgId())
            ->orWhere('from_org_id', authUserOrgId());
    })->with('latestMessage')
        ->get()
        ->reject(function (object $item) {
            if ($item->to_org_id === authUserOrgId()) {
                $item->is_seen = $item->to_org_last_seen_at >= $item->latestMessage->created_at;
            } else if ($item->from_org_id === authUserOrgId()) {
                $item->is_seen = $item->from_org_last_seen_at >= $item->latestMessage->created_at;
            }
            return $item->is_seen;

        })->count();
    return $count;
}

function demoInterests()
{
    return [
        [
            'name'          => 'Collaboration',
            'children'      => [
                [
                    'name'          => 'Tender',
                    'children'      => [
                        ['name' => 'Federal Government'],
                        ['name' => 'State/Territory Government'],
                        ['name' => 'Non-government'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Project',
                    'children'      => [
                        ['name' => 'Federal Government'],
                        ['name' => 'State/Territory Government'],
                        ['name' => 'Non-government'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Social Enterprise',
                    'children'      => [],
                    'selectedItems' => []
                ],
            ],
            'selectedItems' => []
        ],
        [
            'name'          => 'Potential Merger',
            'children'      => [],
            'selectedItems' => []
        ],
        [
            'name'          => 'Resources',
            'children'      => [
                [
                    'name'          => 'Premises',
                    'children'      => [
                        ['name' => 'Office'],
                        ['name' => 'Warehouse'],
                        ['name' => 'Residential'],
                        ['name' => 'Commercial Kitchen'],
                        ['name' => 'Other'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Vehicles',
                    'children'      => [
                        ['name' => 'Van'],
                        ['name' => 'Truck'],
                        ['name' => 'Sedan'],
                        ['name' => 'Bus'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Volunteers',
                    'children'      => [
                        ['name' => 'Manual'],
                        ['name' => 'Fundraising'],
                        ['name' => 'Administrative'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Back office services',
                    'children'      => [
                        ['name' => 'Financial'],
                        ['name' => 'IT'],
                        ['name' => 'HR'],
                        ['name' => 'General administration'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Professional services',
                    'children'      => [
                        ['name' => 'Accounting'],
                        ['name' => 'Legal'],
                        ['name' => 'PR'],
                        ['name' => 'IT'],
                        ['name' => 'Marketing'],
                        ['name' => 'Project Management'],
                    ],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Equipment',
                    'children'      => [
                        ['name' => 'Office'],
                        ['name' => 'Kitchen'],
                        ['name' => 'Other'],
                    ],
                    'selectedItems' => []
                ],
            ],
            'selectedItems' => []
        ],
        [
            'name'          => 'Sponsorship',
            'children'      => [
                [
                    'name'          => 'For project',
                    'children'      => [],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'For an event',
                    'children'      => [],
                    'selectedItems' => []
                ],
                [
                    'name'          => 'Ongoing',
                    'children'      => [],
                    'selectedItems' => []
                ],
            ],
            'selectedItems' => []
        ]
    ];
}

/**
 * fixed workflows steps
 */
if (!function_exists('workflowSteps')) {
    function workflowSteps()
    {
        return [
            'new'         => 'New',
            'in-progress' => 'In Progress',
            'done'        => 'Done'
        ];
    }
}

/**
 * List of preferences
 */
if (!function_exists('preferencesList')) {
    function preferencesList()
    {
        return collect([
            'Office space to Share',
            'Office space to rent',
            'Storage to share',
            'Storage to rent',
            'IT support',
            'Development Support',
            'NDIS provider',
            'Aged Care service'
        ])->mapWithKeys(fn($value) => [Str::slug($value) => $value])->all();
    }
}

/**
 * fixed workflows steps
 */
if (!function_exists('authUserOrgId')) {
    function authUserOrgId()
    {
        return auth()->user()->organisationUser()->first()->organisation_id ?? null;
    }
}

/**
 * Auth user primary organisation
 */
if (!function_exists('authUserPrimaryOrg')) {
    function authUserPrimaryOrg(bool $relation = false, array $relations = [])
    {
        return auth()->user()->organisations()
            ->whereIsPrimary(true)
            ->when(
                $relation,
                fn($query) => $query->with($relations)
            )->first() ?? null;
    }
}

/**
 * Auth user org preferences
 */
if (!function_exists('authUserOrgPreferences')) {
    function authUserOrgPreferences()
    {
        $preferences = null;
        $org         = authUserPrimaryOrg(true, [
            'preferences',
            'preferences.category',
            'preferences.category.parent',
            'preferences.category.parent.parent'
        ]);
        if ($org && $org->preferences->count()) {
            $preferences = $org->preferences;
        }
        return $preferences;
    }
}

/**
 * Auth user org categories
 */
if (!function_exists('authUserOrgCategories')) {
    function authUserOrgCategories()
    {
        $categories = null;
        $org        = authUserPrimaryOrg(true, ['categories', 'categories.parent', 'categories.parent.parent']);
        if ($org && $org->categories->count()) {
            $categories = $org->categories;
        }
        return $categories;
    }
}

/**
 * Auth user org categories
 */
if (!function_exists('authUserOrgCategoryIds')) {
    function authUserOrgCategoryIds()
    {
        // get all categories id and if has parent then get parent id and then parent has parent then get parent id
        $defaultPrefCategories = authUserOrgCategories();
        return $defaultPrefCategories && $defaultPrefCategories->count() ? $defaultPrefCategories->map(function ($category) {
            $ids = [];
            if ($category->parent_id) {
                $parent = $category->parent;
                $ids[]  = $parent->id;
                if ($parent->parent_id) {
                    $ids[] = $parent->parent_id;
                }
            }
            $ids[] = $category->id;
            return $ids;
        })->flatten()->unique()->toArray() : [];
    }
}

/**
 * Auth user org purchased document ids
 */
if (!function_exists('authUserOrgPurchasedDocumentIds')) {
    function authUserOrgPurchasedDocumentIds(): array
    {
        return OrderDetail::whereHas('order', function ($query) {
            $query->where('organisation_id', authUserOrgId());
        })->pluck('document_id')->unique()->toArray() ?? [];
    }
}

/**
 * Check expired or not.
 */
if (!function_exists('isSubscriptionExpired')) {
    function isSubscriptionExpired($date)
    {
        $currentDate = Carbon::now()->toDateString();
        $expiryDate  = Carbon::create($date);

        if ($expiryDate->lessThan($currentDate)) {
            return true;
        }
        $days = $expiryDate->diffInDays($currentDate);

        return ($days < 15) ? $days : false;
    }
}

/**
 * Check expired or not.
 */
if (!function_exists('lastActiveTime')) {
    function lastActiveTime($date)
    {
        $currentDate = Carbon::now();
        $activeDate  = Carbon::create($date);

        $seconds = $currentDate->diffInSeconds($activeDate);
        if ($seconds < 60) {
            return "{$seconds} seconds";
        }

        $minutes = $currentDate->diffInMinutes($activeDate);
        if ($minutes < 60) {
            return "{$minutes} Minutes";
        }

        $hours = $currentDate->diffInHours($activeDate);
        if ($hours < 24) {
            return "{$hours} Hours";
        }

        $days = $currentDate->diffInDays($activeDate);
        if ($days < 31) {
            return "{$days} Days";
        }

        $month = $currentDate->diffInMonths($activeDate);
        if ($month < 12) {
            return "{$month} Month";
        }

        $years = $currentDate->diffInYears($activeDate);
        return "{$years} Years";
    }
}

/**
 * Upload image and return the uploaded path
 *
 * @param $image
 * @param $request_path
 * @param $size
 * @param $old_image
 * @return string
 */
if (!function_exists('imageUploadHandler')) {
    function imageUploadHandler($image, $request_path = 'default', $size = null, $old_image = null): string
    {
        if (isset($old_image)) {
            if (Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
        }

        $path = $image->store($request_path, 'public');

        if (isset($size)) {
            $request_size = explode('x', $size);
            $width        = $request_size[0]; // width
            $height       = $request_size[1]; // height

            $image = Image::make(Storage::disk('public')->get($path))->resize($width, $height)->encode();
            Storage::disk('public')->put($path, $image);
        }

        return $path;
    }


    /**
     * Get file from storage folder
     *
     * @param $url
     * @param string $type
     * @return string
     */
    if (!function_exists('storageLink')) {
        function storageLink($url, $type = 'default'): string
        {
            $img = [
                '128/5968/5968705.png',
                '128/5977/5977575.png',
                '128/2702/2702598.png',
                '128/5968/5968835.png',
                '128/5149/5149174.png',
                '128/3698/3698156.png',
            ];
            if (!is_null($url) && Storage::disk('public')->exists($url)) {
                return Storage::disk('public')->url($url);
            } else {
                if ($type == 'user') {
                    return asset('assets/img/avatar.png');
                }
                if ($type == 'org') {
                    return "https://cdn-icons-png.flaticon.com/" . $img[rand(0, 5)];
                }
                return asset('assets/img/avatar.png');
            }
        }
    }

    /**
     * Check file is exists or not
     *
     * @param string $url
     * @return bool
     */
    if (!function_exists('is_exists')) {
        function is_exists($url): bool
        {
            if (!is_null($url) && Storage::disk('public')->exists($url)) {
                $is_exist = true;
            } else {
                $is_exist = false;
            }

            return $is_exist;
        }
    }

    /**
     * Check file is exists or not, if exists then delete
     *
     * @param string $url
     * @return bool
     */
    if (!function_exists('deleteFile')) {
        function deleteFile($url): bool
        {
            if (!is_null($url) && Storage::disk('public')->exists($url)) {
                Storage::disk('public')->delete($url);
                return true;
            }
            return false;
        }
    }

    if (!function_exists('cleanHtmlFromText')) {
        function cleanHtmlFromText($text): string
        {
            // Remove HTML tags
            $strippedText = strip_tags($text);

            // Remove special characters
            return htmlspecialchars_decode($strippedText, ENT_QUOTES);
        }
    }

}
