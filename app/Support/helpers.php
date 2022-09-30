<?php

if (! function_exists('app_copyright')) {
    /**
     * Get the application copyright.
     *
     * @return string
     */
    function app_copyright()
    {
        return Settings::locale()->get('copyright');
    }
}
if (! function_exists('app_name')) {
    /**
     * Get the application name.
     *
     * @return string
     */
    function app_name()
    {
        return Settings::locale()
            ->get('name', config('app.name', 'Laravel'))
            ?: config('app.name', 'Laravel');
    }
}

if (! function_exists('app_logo')) {
    /**
     * Get the application logo url.
     *
     * @return string
     */
    function app_logo()
    {
        if (($model = Settings::instance('logo')) && $file = $model->getFirstMediaUrl('logo')) {
            return $file;
        }

        return 'https://ui-avatars.com/api/?name='.rawurldecode(config('app.name')).'&bold=true';
    }
}

if (! function_exists('app_favicon')) {
    /**
     * Get the application favicon url.
     *
     * @return string
     */
    function app_favicon()
    {
        if (($model = Settings::instance('favicon')) && $file = $model->getFirstMediaUrl('favicon')) {
            return $file;
        }

        return '/favicon.ico';
    }
}

if (! function_exists('home_slider')) {
    /**
     * Get the home slider images.
     *
     * @return array
     */
    function home_slider()
    {
        if (($model = Settings::instance('home_slider'))) {
            return $model->getMedia('home_slider')->map->getUrl();
        }

        return [];
    }
}

if (! function_exists('count_formatted')) {
    /**
     * Format numbers to nearest thousands such as
     * Kilos, Millions, Billions, and Trillions with comma.
     *
     * @param int|float $num
     * @return float|string
     */
    function count_formatted($num)
    {
        if ($num >= 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = ['K', 'M', 'B', 'T'];
            $x_count_parts = count($x_array) - 1;
            $x_display = $x_array[0].((int) $x_array[1][0] !== 0 ? '.'.$x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }
}

if (! function_exists('price')) {
    /**
     * Retrieve the given price with currency.
     *
     * @param mixed $price
     * @return \App\Support\Price
     */
    function price($price)
    {
        return new \App\Support\Price($price);
    }
}

if (! function_exists('get_date')) {
    /**
     * Retrieve the given date for humans.
     *
     * @param mixed $date
     * @return \App\Support\Date
     */
    function get_date($date)
    {
        return new \App\Support\Date($date);
    }
}
if (! function_exists('filter_html')) {
    /**
     * Remove dangerous tags (with attributes) from html.
     *
     * @param string $html
     *
     * @return string
     */
    function filter_html($html, $defaultAllowed = null)
    {
        if (! $defaultAllowed) {
            $defaultAllowed = 'div,img[src],a[href|title],blockquote[cite],h1,h2,h3,h4,h5,b,i,tt,hr,strong,span,s,p,code,pre,em,ul,ol,li,table,thead,tbody,tr,td,th,br,*[style|class]';
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $allowed = config('editor.allowed_tags', $defaultAllowed);

        // put here every tag and attribute that you want to pass through
        //            $config->set('HTML.AllowedAttributes', '*.style');
        $config->set('HTML.Allowed', $allowed);

        $purifier = new HTMLPurifier($config);

        // return the filtered elements.
        return $purifier->purify($html);
    }
}
