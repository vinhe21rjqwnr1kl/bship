<?php

use Stevebauman\Purify\Definitions\Html5Definition;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Config
    |--------------------------------------------------------------------------
    |
    | This option defines the default config that is provided to HTMLPurifier.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Config sets
    |--------------------------------------------------------------------------
    |
    | Here you may configure various sets of configuration for differentiated use of HTMLPurifier.
    | A specific set of configuration can be applied by calling the "config($name)" method on
    | a Purify instance. Feel free to add/remove/customize these attributes as you wish.
    |
    | Documentation: http://htmlpurifier.org/live/configdoc/plain.html
    |
    |   Core.Encoding               The encoding to convert input to.
    |   HTML.Doctype                Doctype to use during filtering.
    |   HTML.Allowed                The allowed HTML Elements with their allowed attributes.
    |   HTML.ForbiddenElements      The forbidden HTML elements. Elements that are listed in this
    |                               string will be removed, however their content will remain.
    |   CSS.AllowedProperties       The Allowed CSS properties.
    |   AutoFormat.AutoParagraph    Newlines are converted in to paragraphs whenever possible.
    |   AutoFormat.RemoveEmpty      Remove empty elements that contribute no semantic information to the document.
    |
    */

    'configs' => [

        'default' => [
            'Core.Encoding' => 'utf-8',
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => '
                                address,
                                a[href|rel|rev|name|target|title|class|id],
                                abbr,
                                acronym,
                                article,
                                aside,
                                b,
                                bdo,
                                big,
                                blockquote[cite],
                                br,
                                caption[align],
                                cite,
                                code,
                                col[align|charoff|span|valign|width],
                                colgroup[align|charoff|span|valign|width],
                                del[datetime],
                                dd,
                                dfn,
                                div[align|class|id|align|style],
                                dl,
                                dt,
                                em,
                                figure[class|id],
                                font[color|face|size],
                                footer[class|id],
                                h1[align|class|id],
                                h2[align|class|id],
                                h3[align|class|id],
                                h4[align|class|id],
                                h5[align|class|id],
                                h6[align|class|id],
                                header[class|id],
                                hr[align|noshade|size|width|class],
                                i[class],
                                img[alt|align|border|height|hspace|longdesc|vspace|src|width|class|id],
                                ins[datetime|cite],
                                kbd,
                                mark,
                                menu,
                                nav[class|id],
                                p[align|class|id],
                                pre[width],
                                q[cite],
                                .htaccess,
                                samp,
                                span[class|id],
                                section[class|id],
                                small,
                                strike,
                                strong,
                                sub,
                                sup,
                                table[align|bgcolor|border|cellpadding|cellspacing|rules|summary|width|class|id],
                                tbody[align|charoff|valign|class],
                                td[abbr|align|bgcolor|charoff|colspan|height|nowrap|rowspan|scope|valign|width|class|id],
                                tfoot[align|charoff|valign|class],
                                th[abbr|align|bgcolor|charoff|colspan|height|nowrap|rowspan|scope|valign|width|class|id],
                                thead[align|charoff|valign|class],
                                tr[align|bgcolor|charoff|valign|class|id],
                                tt,
                                u,
                                ul[type|class|id],
                                ol[start|type],
                                li[class|id],
                                var,
                                video[controls|height|poster|preload|src|width]',
            'HTML.ForbiddenElements' => '',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,background-image,text-align',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | HTMLPurifier definitions
    |--------------------------------------------------------------------------
    |
    | Here you may specify a class that augments the HTML definitions used by
    | HTMLPurifier. Additional HTML5 definitions are provided out of the box.
    | When specifying a custom class, make sure it implements the interface:
    |
    |   \Stevebauman\Purify\Definitions\Definition
    |
    | Note that these definitions are applied to every Purifier instance.
    |
    | Documentation: http://htmlpurifier.org/docs/enduser-customize.html
    |
    */

    'definitions' => Html5Definition::class,

    /*
    |--------------------------------------------------------------------------
    | Serializer location
    |--------------------------------------------------------------------------
    |
    | The location where HTMLPurifier can store its temporary serializer files.
    | The filepath should be accessible and writable by the web server.
    | A good place for this is in the framework'.htaccess own storage path.
    |
    */

    'serializer' => storage_path('app/purify'),

];
