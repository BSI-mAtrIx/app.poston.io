<?php
$dp_default = array(
    'content_generator' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array(
                'lang' => $this->lang->line('Characters to generate (not used dissapear)'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3231 => 'set',
                    3232 => 0,
                    340 => 0
                )
            )
        ),
        'modules' => array(
            340, //AI Reply
            3231, //Content Generator Characters (not used dissapear)
            3232 //credits access
        ),
    ),
    'social_posting' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts per platform
                'lang' => $this->lang->line('Connected accounts per platform'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    107 => 'set',
                    103 => 'set',
                    101 => 'set',
                    105 => 'set',
                    108 => 'set',
                    33 => 'set',
                    277 => 'set',
                    109 => 'set',
                    100 => 0
                ),
            ),
            1 => array( //Post per month per platform
                'lang' => $this->lang->line('Post per month'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    269 => 'set',
                    276 => 'set',
                    114 => 'set',
                    111 => 'set',
                    113 => 'set',
                    110 => 'set',
                    112 => 'set',
                    296 => 'set',
                    256 => 'set',
                    3008 => 0
                ),
                'bulk_limit' => array(
                    269 => 0,
                    276 => 0,
                    114 => 0,
                    111 => 0,
                    113 => 0,
                    110 => 0,
                    112 => 0,
                    296 => 0,
                    256 => 0,
                ),
            ),
        ),
        'modules' => array(
            269, //	Auto Feed - WordPress Feed Post
            276, //		Auto Feed - YouTube Video Post
            100, //		Comboposter Access
            107, //		Comboposter Blogger Account Import
            114, //		Comboposter HTML Post
            111, //		Comboposter Image Post
            113, //		Comboposter Link Post
            103, //		Comboposter Linkedin Account Import
            101, //		Comboposter Pinterest Account Import
            105, //		Comboposter Reddit Account Import
            110, //		Comboposter Text Post
            112, //		Comboposter Video Post
            108, //		Comboposter Wordpress Account Import
            33, //		Comboposter Youtube Account Import
            277, //		Social Poster - Account Import : Medium
            109, //		Social Poster - Account Import : WordPress (Self hosted)
            296, //		Instagram Posting : Image/Video Post
            3008, //		Instagram Extended Statistics
            256, //		RSS Auto Posting
        ),

    ),
    'twitter_posting' => array( //only as addon for social posting
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts per platform
                'lang' => $this->lang->line('Connected accounts per platform'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    102 => 'set',
                ),
            ),
        ),
        'modules' => array(
            102, //	Comboposter Twitter Account Import
        ),

    ),
    'comment_automation' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //campaigns limit if fb/ig is activated
                'lang' => $this->lang->line('Campaigns'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    251 => 'set',
                    80 => 'set',
                    202 => 'set',
                    201 => 'set',
                    88 => 'set',
                    204 => 'set',
                    278 => 'set',
                    279 => 'set',
                    320 => 0
                ),
            ),
        ),
        'modules' => array(
            251, //	Comment Automation : Auto Comment Campaign
            80, //	Comment Automation : Auto Reply Posts
            202, //	Comment Reply Enhancers : Bulk Comment Reply Campaign
            201, //	Comment Reply Enhancers : Comment & Bulk Tag Campaign
            88, //	Comment Reply Enhancers : Comment Hide/Delete and Reply with multimedia content
            204, //	Comment Reply Enhancers : Full Page Auto Reply
            278, //	Instagram Auto Comment Reply
            279, //	Instagram Auto Comment Reply
            320, //	Instagram Bot and Private Reply - Campaigns
        ),
    ),
    'ecommerce' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //stores
                'lang' => $this->lang->line('Stores limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    268 => 'set',
                    310 => 0,
                    266 => 0,
                    293 => 'set',
                    3100 => 0,
                    281 => 0
                ),
            ),
            1 => array( //products
                'lang' => $this->lang->line('Limit products per store'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    316 => 'set',
                    317 => 0,
                    4001 => 'set',
                ),
            ),
        ),
        'modules' => array(
            3100, //	Custom Domain Access
            316, //	E-commerce Digital Product
            281, //	E-commerce Product Price Variation
            317, //	E-commerce Related Products
            4001, //	Ecommerce Products Limit
            268, //	Messenger E-commerce
            310, //	Whatsapp Send Order
            266, //	WooCommerce Abandoned Cart Recovery
            293, //	WooCommerce Integration
        ),

    ),
    'email_sending' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //stores
                'lang' => $this->lang->line('Send email limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    263 => 'set',
                    271 => 0,
                    290 => 0,
                ),
            ),
        ),
        'modules' => array(
            263, //	Email Broadcast - Email Send
            271, //	Email Broadcast - Sequence Campaign
            290, //Email Phone Opt-in Form Builder
        ),
    ),
    'facebook' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //facebook pages
                'lang' => $this->lang->line('Connected pages'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    65 => 1,
                    200 => 'set',
                ),
            ),
            1 => array( //live streaming
                'lang' => $this->lang->line('Live streaming campaigns'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    252 => 'set',
                    254 => 'set',
                ),
            ),
            2 => array( //posts
                'lang' => $this->lang->line('Posts limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    223 => 'set',
                    222 => 'set',
                    220 => 'set',
                ),
            ),

        ),
        'modules' => array(
            65, //	Facebook Accounts
            254, //	Facebook Live Streaming - Crossposting/Auto Share/Comment
            200, //	Facebook Pages
            223, //	Facebook Posting : Text/Image/Link/Video Post
            222, //	Facebook Posting : Carousel/Slider Post
            220, //	Facebook Posting : CTA Post
            252, //	Facebook Posting : Live Streaming Campaigns
        ),
    ),
    'google' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts
                'lang' => $this->lang->line('Connected accounts'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    300 => 'set',
                ),
            ),
            1 => array( //Post per month per platform
                'lang' => $this->lang->line('Post limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    301 => 'set',
                    304 => 'set',
                    303 => 'set',
                    302 => 'set',
                    305 => 'set',
                ),
                'bulk_limit' => array(
                    303 => 0,
                    304 => 0,
                ),
            ),
        ),
        'modules' => array(
            300, //	Google My Business: Account Import
            301, //	Google My Business: Answer To Questions
            304, //	Google My Business: Media Upload To Locations
            303, //	Google My Business: Post To Locations
            302, //	Google My Business: Reply To Reviews
            305, //	Google My Business: RSS Auto Posting
        ),

    ),
    'image_editor' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts per platform
                'lang' => $this->lang->line('Access to image editors'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3004 => 0,
                    3005 => 0,
                    3006 => 0,
                    3884 => 0
                ),
            ),
        ),
        'modules' => array(
            3004, //	Image Editor (Pixie)
            3005, //	Image Editor N2
            3006, //	Image Editor N3
            3884, //	Image Editor N4 (Palleon)
        ),
    ),
    'messenger' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Subscriber Limit
                'lang' => $this->lang->line('Subscriber limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    66 => 'set',
                    258 => 0,
                    261 => 0,
                    265 => 0,
                    211 => 0,
                    213 => 0,
                    217 => 0,
                    215 => 0,
                    214 => 0,
                    218 => 0,
                    219 => 0,
                    275 => 0,
                    257 => 0,
                    777 => 0,
                    292 => 0,
                    79 => 0,
                    778 => 0,
                    330 => 0,
                    82 => 0,
                    199 => 0,
                    197 => 0,
                    325 => 0,
                    78 => 0,
                    315 => 0
                ),
                'bulk_limit' => array(
                    211 => 0,
                    257 => 0,
                ),
            ),
        ),
        'modules' => array(
            66, //  Facebook Pages - Subscribers/Page
            82, //	Live Chat
            199, //	Messenger Bot
            258, //	Messenger Bot - Connectivity : JSON API
            261, //	Messenger Bot - Connectivity : Webview Builder
            265, //	Messenger Bot - Email Auto Responder
            211, //	Messenger Bot - Enhancers : Broadcast : Subscriber Bulk Message Send
            213, //	Messenger Bot - Enhancers : Engagement : Checkbox Plugin
            217, //	Messenger Bot - Enhancers : Engagement : Customer Chat Plugin
            215, //	Messenger Bot - Enhancers : Engagement : m.me Links
            214, //	Messenger Bot - Enhancers : Engagement : Send to Messenger
            218, //	Messenger Bot - Enhancers : Sequence Messaging : Message Send
            219, //	Messenger Bot - Enhancers : Sequence Messaging Campaign
            275, //	One Time Notification Send
            197, //	Messenger Bot - Persistent Menu
            257, //	Messenger Bot : Export, Import & Tree View
            325, //Messenger Bot Condition
            //198, //	Messenger Bot - Persistent Menu : Copyright Enabled
            778, //	Flow Builder - Allow Subscribers To Use Templates
            777, //	Flow Builder - Limit On Number Of Flows User Can Create
            330, //	Flowbuilder Insignt
            78, //	Subscriber Manager : Background Lead Scan
            292, //	User Input Flow Campaign
            315, //	Visual flow builder access
            79, //	Conversation Promo Broadcast Send
        ),

    ),
    'sms' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //sms send
                'lang' => $this->lang->line('Send SMS limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    264 => 'set',
                    270 => 0
                ),
            ),
        ),
        'modules' => array(
            270, //	SMS Broadcast - Sequence Campaign
            264, //	SMS Broadcast - SMS Send
        ),

    ),
    'telegram' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts per platform
                'lang' => $this->lang->line('Connected phone numbers'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    4102 => 'set',
                ),
            ),
            1 => array( //subscribers per bot
                'lang' => $this->lang->line('Subscriber limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    4104 => 'set',
                ),
            ),
        ),
        'modules' => array(
            4102, //	Telegram Bot Connected
            //4106, //	Telegram Bot Platform Brand Name
            4104, //	Telegram Bot Subscribers limit
        ),

    ),
    'whatsapp' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts per platform
                'lang' => $this->lang->line('Connected phone numbers'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    4112 => 'set',
                    3007 => 0
                ),
            ),
            1 => array( //subscribers per bot
                'lang' => $this->lang->line('Subscriber limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    4114 => 'set',
                ),
            ),
            2 => array( //custom api
                'lang' => $this->lang->line('Customer App Details'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    4118 => 'set',
                ),
            ),
        ),
        'modules' => array(
            4112, //	WhatsApp Bot Connected
            4118, //	WhatsApp Bot Custom API
            //4116, //	WhatsApp Bot Platform Brand Name
            4114, //	WhatsApp Bot Subscribers limit
            3007, //	Whatsapp Link Generator
        ),

    ),
    'meta_ads' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts
                'lang' => $this->lang->line('Connected ad accounts'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3300 => 'set',
                ),
            ),
        ),
        'modules' => array(
            3300, //	Meta Ads Manager
        ),
    ),
    'utility' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts
                'lang' => $this->lang->line('Access to tools'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    267 => 0,
                    3010 => 0
                ),
            ),
        ),
        'modules' => array(
            267, //	Utility Search Tools
            3010, //	To Do List / Kanban
        ),
    ),
    'hidden_interest' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //Connected accounts
                'lang' => $this->lang->line('Access to tool'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3003 => 0,
                ),
            ),
        ),
        'modules' => array(
            3003, //	Hidden Interest Explorer
        ),
    ),
    'landing_page' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //pages
                'lang' => $this->lang->line('Pages limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3450 => 'set',
                ),
            ),
        ),
        'modules' => array(
            3450, //	Landing Page
        ),
    ),
    'website_builder' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array( //pages
                'lang' => $this->lang->line('Website limit'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3451 => 'set',
                ),
            ),
        ),
        'modules' => array(
            3451, //	Website Builder
        ),
    ),
    'credits' => array(
        'enabled' => 0,
        'free' => 0,
        'config' => '',
        'sliders' => array(
            0 => array(
                'lang' => $this->lang->line('Credits points to use in WhatsApp or Content Generator'),
                'max_val' => 1,
                'config' => '',
                'unit' => 1,
                'monthly_limit' => array(
                    3232 => 'set',
                )
            )
        ),
        'modules' => array(
            3232, //credits access
            340, //AI Reply
            3231, //Content Generator Characters (not used dissapear)
        ),
    ),
);