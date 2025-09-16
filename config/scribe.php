<?php

use Knuckles\Scribe\Config\AuthIn;
use Knuckles\Scribe\Config\Defaults;
use Knuckles\Scribe\Extracting\Strategies;
use App\Scribe\Strategies\CustomBodyParameters;


use function Knuckles\Scribe\Config\configureStrategy;
use function Knuckles\Scribe\Config\removeStrategies;

// Only the most common configs are shown. See the https://scribe.knuckles.wtf/laravel/reference/config for all.

return [
    // The HTML <title> for the generated documentation.
//    'title' => config('app.name').' API Documentation',
    'title' => config('app.name').' API Documentation ('.date('Y-m-d H:i:s').')',

    // A short description of your API. Will be included in the docs webpage, Postman collection and OpenAPI spec.
    'description' => 'Short description for API',

    // The base URL displayed in the docs.
    // If you're using `laravel` type, you can set this to a dynamic string, like '{{ config("app.tenant_url") }}' to get a dynamic base URL.
    'base_url' => config('app.url'),

    // Routes to include in the docs
    'routes' => [
        [
            'match' => [
                // Match only routes whose paths match this pattern (use * as a wildcard to match any characters). Example: 'users/*'.
                'prefixes' => ['api/*'],

                // Match only routes whose domains match this pattern (use * as a wildcard to match any characters). Example: 'api.*'.
                'domains' => ['*'],
            ],

            // Include these routes even if they did not match the rules above.
            'include' => [
                // 'users.index', 'POST /new', '/auth/*'
            ],

            // Exclude these routes even if they matched the rules above.
            'exclude' => [
                'GET api/v1/search',
                // 'GET /health', 'admin.*'
            ],
        ],
    ],

    // The type of documentation output to generate.
    // - "static" will generate a static HTMl page in the /public/docs folder,
    // - "laravel" will generate the documentation as a Blade view, so you can add routing and authentication.
    // - "external_static" and "external_laravel" do the same as above, but pass the OpenAPI spec as a URL to an external UI template
    'type' => 'static',

    // See https://scribe.knuckles.wtf/laravel/reference/config#theme for supported options
    'theme' => 'default',

    'static' => [
        // HTML documentation, assets and Postman collection will be generated to this folder.
        // Source Markdown will still be in resources/docs.
        'output_path' => 'public/docs',
    ],

    'laravel' => [
        // Whether to automatically create a docs route for you to view your generated docs. You can still set up routing manually.
        'add_routes' => true,

        // URL path to use for the docs endpoint (if `add_routes` is true).
        // By default, `/docs` opens the HTML page, `/docs.postman` opens the Postman collection, and `/docs.openapi` the OpenAPI spec.
        'docs_url' => '/docs',

        // Directory within `public` in which to store CSS and JS assets.
        // By default, assets are stored in `public/vendor/scribe`.
        // If set, assets will be stored in `public/{{assets_directory}}`
        'assets_directory' => null,

        // Middleware to attach to the docs endpoint (if `add_routes` is true).
        'middleware' => [],
    ],

    'external' => [
        'html_attributes' => [],
    ],

    'try_it_out' => [
        // Add a Try It Out button to your endpoints so consumers can test endpoints right from their browser.
        // Don't forget to enable CORS headers for your endpoints.
        'enabled' => true,

        // The base URL to use in the API tester. Leave as null to be the same as the displayed URL (`scribe.base_url`).
        'base_url' => null,

        // [Laravel Sanctum] Fetch a CSRF token before each request, and add it as an X-XSRF-TOKEN header.
        'use_csrf' => true,

        // The URL to fetch the CSRF token from (if `use_csrf` is true).
        'csrf_url' => '/sanctum/csrf-cookie',

        'allowed_origins' => ['chrome-extension://*'],
    ],

    // How is your API authenticated? This information will be used in the displayed docs, generated examples and response calls.
    'auth' => [
        // Set true if your API endpoints use authentication
        'enabled' => true,

        // Set true if all your endpoints require authentication by default
        'default' => true,

        // Where the authentication token should be sent
        'in' => AuthIn::BEARER->value,

        // Authentication parameter name
        'name' => 'Authorization',

        // Value for test requests
        'use_value' => env('SCRIBE_AUTH_KEY'),

        // Placeholder that users will see
        'placeholder' => '{YOUR_AUTH_TOKEN}',

        // Additional authentication information
        'extra_info' => 'You can obtain a token via the api/login endpoint',
    ],

    // Text to place in the "Introduction" section, right after the `description`. Markdown and HTML are supported.
    'intro_text' => <<<'INTRO'
        This documentation aims to provide all the information you need to work with our API.

        <aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
        You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
    INTRO,

    // Example requests for each endpoint will be shown in each of these languages.
    // Supported options are: bash, javascript, php, python
    // To add a language of your own, see https://scribe.knuckles.wtf/laravel/advanced/example-requests
    // Note: does not work for `external` docs types
    'example_languages' => [
        'bash',
        'javascript',
        'php',
    ],

    // Generate a Postman collection (v2.1.0) in addition to HTML docs.
    // For 'static' docs, the collection will be generated to public/docs/collection.json.
    // For 'laravel' docs, it will be generated to storage/app/scribe/collection.json.
    // Setting `laravel.add_routes` to true (above) will also add a route for the collection.
    'postman' => [
        'enabled' => true,

        'overrides' => [
            'variable' => [
                [
                    'id' => 'baseUrl',
                    'key' => 'baseUrl',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => config('app.url'),
                ],
                [
                    'id' => 'access_token',
                    'key' => 'access_token',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_email',
                    'key' => 'check_email',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_password',
                    'key' => 'check_password',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_phone',
                    'key' => 'check_phone',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_sms_code',
                    'key' => 'check_sms_code',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],

                [
                    'id' => 'check_reset_token',
                    'key' => 'check_reset_token',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],

                [
                    'id' => 'check_new_password',
                    'key' => 'check_new_password',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_visit_id',
                    'key' => 'check_visit_id',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_employee_id',
                    'key' => 'check_employee_id',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_time_entry_id',
                    'key' => 'check_time_entry_id',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],

                //"help_block": [1,2,3, 4],
                //"mood_tracking": [17,18,19,20],
                //"notes": ["text1", "text2", "text3","text4", "text5"],
                [
                    'id' => 'check_help_block',
                    'key' => 'check_help_block',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_mood_tracking',
                    'key' => 'check_mood_tracking',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_notes',
                    'key' => 'check_notes',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],

                [
                    'id' => 'check_from_date',
                    'key' => 'check_from_date',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
                [
                    'id' => 'check_to_date',
                    'key' => 'check_to_date',
                    'type' => 'string',
                    'name' => 'string',
                    'value' => '',
                ],
            ],

            'event' => [
                [
                    'listen' => 'test',
                    'script' => [
                        'type' => 'text/javascript',
                        'exec' => [
                            "if ((pm.request.url.path.join('/') === 'api/v1/login' || pm.request.url.path.join('/') === 'api/v1/password/reset') && pm.response.code === 200) {",
                            '  const json = pm.response.json();',
                            '  if (json.data && json.data.access_token) {',
                            "    pm.collectionVariables.set('access_token', json.data.access_token);",
                            "    console.log('Access token saved');",
                            '  }',
                            '}',

                            "if (pm.request.url.path.join('/') === 'api/v1/password/verify-code' && pm.response.code === 200) {",
                            '  const json = pm.response.json();',
                            '  if (json.reset_token) {',
                            "    pm.collectionVariables.set('check_reset_token', json.reset_token);",
                            "    console.log('Reset token saved:', json.reset_token);",
                            '  }',
                            '}',

                            "if (pm.request.url.path.join('/') === 'api/v1/me/clock/start' && pm.response.code === 200) {",
                            '  const json = pm.response.json();',
                            '  if (json.time_entry_id) {',
                            "    pm.collectionVariables.set('check_time_entry_id', json.time_entry_id);",
                            "    console.log('check time entry id saved:', json.check_time_entry_id);",
                            '  }',
                            '',
                            '  // Get all help type IDs as an array',
                            '  if (json.help_types && json.help_types.length > 0) {',
                            '    // Extract all help type IDs into an array',
                            '    const helpTypeIds = json.help_types.map(type => type.id);',
                            '',
                            '    // Store the array as a JSON string in the collection variable',
                            '    pm.collectionVariables.set(\'check_help_block\', JSON.stringify(helpTypeIds));',
                            '    console.log(\'check help block IDs saved:\', helpTypeIds);',
                            '  }',
                            '',
                            '  // Get all mood type IDs as an array',
                            '  if (json.mood_types && json.mood_types.length > 0) {',
                            '    // Extract all mood type IDs into an array',
                            '    const moodTypeIds = json.mood_types.map(type => type.id);',
                            '',
                            '    // Store the array as a JSON string in the collection variable',
                            '    pm.collectionVariables.set(\'check_mood_tracking\', JSON.stringify(moodTypeIds));',
                            '    console.log(\'check mood tracking IDs saved:\', moodTypeIds);',
                            '  }',
                            '}',
                        ],
                    ],
                ],
                // ⬇️ 2. Логаут — очищаємо токен
                [
                    'listen' => 'test',
                    'script' => [
                        'type' => 'text/javascript',
                        'exec' => [
                            "if (pm.request.url.path.join('/') === 'api/logout' && pm.response.code === 200) {",
                            "  pm.collectionVariables.set('access_token', '');",
                            "  console.log('access_token cleared');",
                            '}',
                        ],
                    ],
                ],
            ],

            'auth' => [
                'type' => 'bearer',
                'bearer' => [
                    [
                        'key' => 'token',
                        'value' => '{{access_token}}',
                        'type' => 'string',
                    ],
                ],
            ],
        ],

//        'environments' => [
//            [
//                'name' => 'Local',
//                'variables' => [
//                    [
//                        'key' => 'baseUrl',
//                        'value' => 'http://localhost',
//                        'type' => 'string'
//                    ]
//                ]
//            ],
//            [
//                'name' => 'Docker',
//                'variables' => [
//                    [
//                        'key' => 'baseUrl',
//                        'value' => 'http://solid-cms',
//                        'type' => 'string'
//                    ]
//                ]
//            ],
//            [
//                'name' => 'Production',
//                'variables' => [
//                    [
//                        'key' => 'baseUrl',
//                        'value' => 'https://your-production-url.com',
//                        'type' => 'string'
//                    ]
//                ]
//            ]
//        ]
    ],

    // Generate an OpenAPI spec (v3.0.1) in addition to docs webpage.
    // For 'static' docs, the collection will be generated to public/docs/openapi.yaml.
    // For 'laravel' docs, it will be generated to storage/app/scribe/openapi.yaml.
    // Setting `laravel.add_routes` to true (above) will also add a route for the spec.
    'openapi' => [
        'enabled' => true,

        'overrides' => [
            // 'info.version' => '2.0.0',
        ],

        // Additional generators to use when generating the OpenAPI spec.
        // Should extend `Knuckles\Scribe\Writing\OpenApiSpecGenerators\OpenApiGenerator`.
        'generators' => [],
    ],

    'groups' => [
        // Endpoints which don't have a @group will be placed in this default group.
        'default' => 'Endpoints',

        // By default, Scribe will sort groups alphabetically, and endpoints in the order their routes are defined.
        // You can override this by listing the groups, subgroups and endpoints here in the order you want them.
        // See https://scribe.knuckles.wtf/blog/laravel-v4#easier-sorting and https://scribe.knuckles.wtf/laravel/reference/config#order for details
        // Note: does not work for `external` docs types
        'order' => [],
    ],

    // Custom logo path. This will be used as the value of the src attribute for the <img> tag,
    // so make sure it points to an accessible URL or path. Set to false to not use a logo.
    // For example, if your logo is in public/img:
    // - 'logo' => '../img/logo.png' // for `static` type (output folder is public/docs)
    // - 'logo' => 'img/logo.png' // for `laravel` type
    'logo' => false,

    // Customize the "Last updated" value displayed in the docs by specifying tokens and formats.
    // Examples:
    // - {date:F j Y} => March 28, 2022
    // - {git:short} => Short hash of the last Git commit
    // Available tokens are `{date:<format>}` and `{git:<format>}`.
    // The format you pass to `date` will be passed to PHP's `date()` function.
    // The format you pass to `git` can be either "short" or "long".
    // Note: does not work for `external` docs types
    'last_updated' => 'Last updated: {date:F j, Y}',

    'examples' => [
        // Set this to any number to generate the same example values for parameters on each run,
        'faker_seed' => 1234,

        // With API resources and transformers, Scribe tries to generate example models to use in your API responses.
        // By default, Scribe will try the model's factory, and if that fails, try fetching the first from the database.
        // You can reorder or remove strategies here.
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],

    // The strategies Scribe will use to extract information about your routes at each stage.
    // Use configureStrategy() to specify settings for a strategy in the list.
    // Use removeStrategies() to remove an included strategy.
    'strategies' => [
        'metadata' => [
            ...Defaults::METADATA_STRATEGIES,
        ],
        'headers' => [
            ...Defaults::HEADERS_STRATEGIES,
            Strategies\StaticData::withSettings(data: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
        ],
        'urlParameters' => [
            ...Defaults::URL_PARAMETERS_STRATEGIES,
        ],
        'queryParameters' => [
            ...Defaults::QUERY_PARAMETERS_STRATEGIES,
        ],
        'bodyParameters' => [
            ...Defaults::BODY_PARAMETERS_STRATEGIES,
            CustomBodyParameters::class,
        ],
        'responses' => configureStrategy(
            Defaults::RESPONSES_STRATEGIES,
            Strategies\Responses\ResponseCalls::withSettings(
                only: ['GET *'],
                // Recommended: disable debug mode in response calls to avoid error stack traces in responses
                config: [
                    'app.debug' => false,
                ]
            )
        ),
        'responseFields' => [
            ...Defaults::RESPONSE_FIELDS_STRATEGIES,
        ],
    ],

    // For response calls, API resource responses and transformer responses,
    // Scribe will try to start database transactions, so no changes are persisted to your database.
    // Tell Scribe which connections should be transacted here. If you only use one db connection, you can leave this as is.
    'database_connections_to_transact' => [config('database.default')],

    'fractal' => [
        // If you are using a custom serializer with league/fractal, you can specify it here.
        'serializer' => null,
    ],
];
