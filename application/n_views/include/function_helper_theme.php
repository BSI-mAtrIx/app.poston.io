<?php
$selected_global_media_type = $this->session->userdata('selected_global_media_type');
if ($selected_global_media_type == '') $selected_global_media_type = 'fb';


function LangToCode($value_langCode, $n_config)
{
    switch (strtolower($value_langCode)) {
        case 'chinese';
            $flag = 'cn';
            break;
        case 'arabic';
            $flag = $n_config['arabic_lang_icon'];
            break;
        case 'english';
            $flag = 'us';
            break;
        case 'polish';
            $flag = 'pl';
            break;
        case 'bengali';
            $flag = 'bn';
            break;
        case 'czech';
            $flag = 'cz';
            break;
        case 'dutch';
            $flag = 'nl';
            break;
        case 'french';
            $flag = 'fr';
            break;
        case 'german';
            $flag = 'de';
            break;
        case 'greek';
            $flag = 'gr';
            break;
        case 'hebrew';
            $flag = $n_config['hebrew_lang_icon'];
            break;
        case 'italian';
            $flag = 'it';
            break;
        case 'portuguese';
            $flag = 'pt';
            break;
        case 'russian';
            $flag = 'ru';
            break;
        case 'spanish';
            $flag = $n_config['spain_lang_icon'];
            break;
        case 'turkish';
            $flag = 'tr';
            break;
        case 'vietnamese';
            $flag = 'vn';
            break;
        case 'romanian';
            $flag = 'ro';
            break;
        case 'thai';
            $flag = 'th';
            break;


        default;
            $flag = '';
            break;
    }

    return $flag;
}

function rand_welcome()
{
    $welcomes = array(
        0 =>
            array(
                'country_code' => 'A1',
                'country_name' => 'Anonymous Proxy',
                'greeting' => 'Hello',
            ),
        1 =>
            array(
                'country_code' => 'A2',
                'country_name' => 'Satellite Provider',
                'greeting' => 'Hello',
            ),
        2 =>
            array(
                'country_code' => 'AD',
                'country_name' => 'Andorra',
                'greeting' => 'Hola',
            ),
        3 =>
            array(
                'country_code' => 'AE',
                'country_name' => 'United Arab Emirates',
                'greeting' => 'Marhaba',
            ),
        4 =>
            array(
                'country_code' => 'AF',
                'country_name' => 'Afghanistan',
                'greeting' => 'Senga yai',
            ),
        5 =>
            array(
                'country_code' => 'AG',
                'country_name' => 'Antigua and Barbuda',
                'greeting' => 'Hello',
            ),
        6 =>
            array(
                'country_code' => 'AI',
                'country_name' => 'Anguilla',
                'greeting' => 'Hello',
            ),
        7 =>
            array(
                'country_code' => 'AL',
                'country_name' => 'Albania',
                'greeting' => 'Tungjatjeta',
            ),
        8 =>
            array(
                'country_code' => 'AM',
                'country_name' => 'Armenia',
                'greeting' => 'Barev',
            ),
        9 =>
            array(
                'country_code' => 'AN',
                'country_name' => 'Netherlands Antilles',
                'greeting' => 'Kon ta bai',
            ),
        10 =>
            array(
                'country_code' => 'AO',
                'country_name' => 'Angola',
                'greeting' => 'Olá',
            ),
        11 =>
            array(
                'country_code' => 'AP',
                'country_name' => 'Asia/Pacific Region',
                'greeting' => 'Hello',
            ),
        12 =>
            array(
                'country_code' => 'AQ',
                'country_name' => 'Antarctica',
                'greeting' => 'Hello',
            ),
        13 =>
            array(
                'country_code' => 'AR',
                'country_name' => 'Argentina',
                'greeting' => 'Hola',
            ),
        14 =>
            array(
                'country_code' => 'AS',
                'country_name' => 'American Samoa',
                'greeting' => 'Hello',
            ),
        15 =>
            array(
                'country_code' => 'AT',
                'country_name' => 'Austria',
                'greeting' => 'Hallo',
            ),
        16 =>
            array(
                'country_code' => 'AU',
                'country_name' => 'Australia',
                'greeting' => 'Hello',
            ),
        17 =>
            array(
                'country_code' => 'AW',
                'country_name' => 'Aruba',
                'greeting' => 'Kon ta bai',
            ),
        18 =>
            array(
                'country_code' => 'AX',
                'country_name' => 'Aland Islands',
                'greeting' => 'Hello',
            ),
        19 =>
            array(
                'country_code' => 'AZ',
                'country_name' => 'Azerbaijan',
                'greeting' => 'Salam',
            ),
        20 =>
            array(
                'country_code' => 'BA',
                'country_name' => 'Bosnia and Herzegovina',
                'greeting' => 'Zdravo',
            ),
        21 =>
            array(
                'country_code' => 'BB',
                'country_name' => 'Barbados',
                'greeting' => 'Hello',
            ),
        22 =>
            array(
                'country_code' => 'BD',
                'country_name' => 'Bangladesh',
                'greeting' => 'Namaskar',
            ),
        23 =>
            array(
                'country_code' => 'BE',
                'country_name' => 'Belgium',
                'greeting' => 'Hallo',
            ),
        24 =>
            array(
                'country_code' => 'BF',
                'country_name' => 'Burkina Faso',
                'greeting' => 'Bonjour',
            ),
        25 =>
            array(
                'country_code' => 'BG',
                'country_name' => 'Bulgaria',
                'greeting' => 'Zdravei',
            ),
        26 =>
            array(
                'country_code' => 'BH',
                'country_name' => 'Bahrain',
                'greeting' => 'Marhaba',
            ),
        27 =>
            array(
                'country_code' => 'BI',
                'country_name' => 'Burundi',
                'greeting' => 'Bonjour',
            ),
        28 =>
            array(
                'country_code' => 'BJ',
                'country_name' => 'Benin',
                'greeting' => 'Bonjour',
            ),
        29 =>
            array(
                'country_code' => 'BM',
                'country_name' => 'Bermuda',
                'greeting' => 'Hello',
            ),
        30 =>
            array(
                'country_code' => 'BN',
                'country_name' => 'Brunei Darussalam',
                'greeting' => 'Selamat',
            ),
        31 =>
            array(
                'country_code' => 'BO',
                'country_name' => 'Bolivia',
                'greeting' => 'Hola',
            ),
        32 =>
            array(
                'country_code' => 'BR',
                'country_name' => 'Brazil',
                'greeting' => 'Olá',
            ),
        33 =>
            array(
                'country_code' => 'BS',
                'country_name' => 'Bahamas',
                'greeting' => 'Hello',
            ),
        34 =>
            array(
                'country_code' => 'BT',
                'country_name' => 'Bhutan',
                'greeting' => 'Kuzu zangpo',
            ),
        35 =>
            array(
                'country_code' => 'BV',
                'country_name' => 'Bouvet Island',
                'greeting' => 'Hello',
            ),
        36 =>
            array(
                'country_code' => 'BW',
                'country_name' => 'Botswana',
                'greeting' => 'Dumela',
            ),
        37 =>
            array(
                'country_code' => 'BY',
                'country_name' => 'Belarus',
                'greeting' => 'Вітаю',
            ),
        38 =>
            array(
                'country_code' => 'BZ',
                'country_name' => 'Belize',
                'greeting' => 'Hello',
            ),
        39 =>
            array(
                'country_code' => 'CA',
                'country_name' => 'Canada',
                'greeting' => 'Hello',
            ),
        40 =>
            array(
                'country_code' => 'CD',
                'country_name' => 'Congo  The Democratic Republic of the',
                'greeting' => 'Bonjour',
            ),
        41 =>
            array(
                'country_code' => 'CF',
                'country_name' => 'Central African Republic',
                'greeting' => 'Bonjour',
            ),
        42 =>
            array(
                'country_code' => 'CG',
                'country_name' => 'Congo',
                'greeting' => 'Bonjour',
            ),
        43 =>
            array(
                'country_code' => 'CH',
                'country_name' => 'Switzerland',
                'greeting' => 'Hallo',
            ),
        44 =>
            array(
                'country_code' => 'CI',
                'country_name' => 'Cote d\'Ivoire',
                'greeting' => 'Bonjour',
            ),
        45 =>
            array(
                'country_code' => 'CK',
                'country_name' => 'Cook Islands',
                'greeting' => 'Kia orana',
            ),
        46 =>
            array(
                'country_code' => 'CL',
                'country_name' => 'Chile',
                'greeting' => 'Hola',
            ),
        47 =>
            array(
                'country_code' => 'CM',
                'country_name' => 'Cameroon',
                'greeting' => 'Hello',
            ),
        48 =>
            array(
                'country_code' => 'CN',
                'country_name' => 'China',
                'greeting' => '&#20320;&#22909;',
            ),
        49 =>
            array(
                'country_code' => 'CO',
                'country_name' => 'Colombia',
                'greeting' => 'Hola',
            ),
        50 =>
            array(
                'country_code' => 'CR',
                'country_name' => 'Costa Rica',
                'greeting' => 'Hola',
            ),
        51 =>
            array(
                'country_code' => 'CU',
                'country_name' => 'Cuba',
                'greeting' => 'Hola',
            ),
        52 =>
            array(
                'country_code' => 'CV',
                'country_name' => 'Cape Verde',
                'greeting' => 'Olá',
            ),
        53 =>
            array(
                'country_code' => 'CY',
                'country_name' => 'Cyprus',
                'greeting' => '&#915;&#949;&#953;&#945; &#963;&#959;&#965;',
            ),
        54 =>
            array(
                'country_code' => 'CZ',
                'country_name' => 'Czech Republic',
                'greeting' => 'Dobrý den',
            ),
        55 =>
            array(
                'country_code' => 'DE',
                'country_name' => 'Germany',
                'greeting' => 'Hallo',
            ),
        56 =>
            array(
                'country_code' => 'DJ',
                'country_name' => 'Djibouti',
                'greeting' => 'Marhaba',
            ),
        57 =>
            array(
                'country_code' => 'DK',
                'country_name' => 'Denmark',
                'greeting' => 'Hej',
            ),
        58 =>
            array(
                'country_code' => 'DM',
                'country_name' => 'Dominica',
                'greeting' => 'Hello',
            ),
        59 =>
            array(
                'country_code' => 'DO',
                'country_name' => 'Dominican Republic',
                'greeting' => 'Hola',
            ),
        60 =>
            array(
                'country_code' => 'DZ',
                'country_name' => 'Algeria',
                'greeting' => 'Marhaba',
            ),
        61 =>
            array(
                'country_code' => 'EC',
                'country_name' => 'Ecuador',
                'greeting' => 'Hola',
            ),
        62 =>
            array(
                'country_code' => 'EE',
                'country_name' => 'Estonia',
                'greeting' => 'Tervist',
            ),
        63 =>
            array(
                'country_code' => 'EG',
                'country_name' => 'Egypt',
                'greeting' => 'Marhaba',
            ),
        64 =>
            array(
                'country_code' => 'ER',
                'country_name' => 'Eritrea',
                'greeting' => 'Marhaba',
            ),
        65 =>
            array(
                'country_code' => 'ES',
                'country_name' => 'Spain',
                'greeting' => 'Hola',
            ),
        66 =>
            array(
                'country_code' => 'ET',
                'country_name' => 'Ethiopia',
                'greeting' => 'Teanastëllën',
            ),
        67 =>
            array(
                'country_code' => 'EU',
                'country_name' => 'Europe',
                'greeting' => 'Hello',
            ),
        68 =>
            array(
                'country_code' => 'FI',
                'country_name' => 'Finland',
                'greeting' => 'Moi',
            ),
        69 =>
            array(
                'country_code' => 'FJ',
                'country_name' => 'Fiji',
                'greeting' => 'Hello',
            ),
        70 =>
            array(
                'country_code' => 'FK',
                'country_name' => 'Falkland Islands (Malvinas)',
                'greeting' => 'Hello',
            ),
        71 =>
            array(
                'country_code' => 'FM',
                'country_name' => 'Micronesia  Federated States of',
                'greeting' => 'Hello',
            ),
        72 =>
            array(
                'country_code' => 'FO',
                'country_name' => 'Faroe Islands',
                'greeting' => 'Hallo',
            ),
        73 =>
            array(
                'country_code' => 'FR',
                'country_name' => 'France',
                'greeting' => 'Bonjour',
            ),
        74 =>
            array(
                'country_code' => 'GA',
                'country_name' => 'Gabon',
                'greeting' => 'Bonjour',
            ),
        75 =>
            array(
                'country_code' => 'GB',
                'country_name' => 'Great Britain',
                'greeting' => 'Hello',
            ),
        76 =>
            array(
                'country_code' => 'GD',
                'country_name' => 'Grenada',
                'greeting' => 'Hello',
            ),
        77 =>
            array(
                'country_code' => 'GE',
                'country_name' => 'Georgia',
                'greeting' => 'Gamardjobat',
            ),
        78 =>
            array(
                'country_code' => 'GF',
                'country_name' => 'French Guiana',
                'greeting' => 'Bonjour',
            ),
        79 =>
            array(
                'country_code' => 'GG',
                'country_name' => 'Guernsey',
                'greeting' => 'Hello',
            ),
        80 =>
            array(
                'country_code' => 'GH',
                'country_name' => 'Ghana',
                'greeting' => 'Hello',
            ),
        81 =>
            array(
                'country_code' => 'GI',
                'country_name' => 'Gibraltar',
                'greeting' => 'Hello',
            ),
        82 =>
            array(
                'country_code' => 'GL',
                'country_name' => 'Greenland',
                'greeting' => 'Aluu',
            ),
        83 =>
            array(
                'country_code' => 'GM',
                'country_name' => 'Gambia',
                'greeting' => 'Hello',
            ),
        84 =>
            array(
                'country_code' => 'GN',
                'country_name' => 'Guinea',
                'greeting' => 'Bonjour',
            ),
        85 =>
            array(
                'country_code' => 'GP',
                'country_name' => 'Guadeloupe',
                'greeting' => 'Hello',
            ),
        86 =>
            array(
                'country_code' => 'GQ',
                'country_name' => 'Equatorial Guinea',
                'greeting' => 'Hola',
            ),
        87 =>
            array(
                'country_code' => 'GR',
                'country_name' => 'Greece',
                'greeting' => '&#915;&#949;&#953;&#945; &#963;&#959;&#965;',
            ),
        88 =>
            array(
                'country_code' => 'GT',
                'country_name' => 'Guatemala',
                'greeting' => 'Hola',
            ),
        89 =>
            array(
                'country_code' => 'GU',
                'country_name' => 'Guam',
                'greeting' => 'Hello',
            ),
        90 =>
            array(
                'country_code' => 'GW',
                'country_name' => 'Guinea-Bissau',
                'greeting' => 'Olá',
            ),
        91 =>
            array(
                'country_code' => 'GY',
                'country_name' => 'Guyana',
                'greeting' => 'Hello',
            ),
        92 =>
            array(
                'country_code' => 'HK',
                'country_name' => 'Hong Kong',
                'greeting' => '&#20320;&#22909;',
            ),
        93 =>
            array(
                'country_code' => 'HN',
                'country_name' => 'Honduras',
                'greeting' => 'HHola',
            ),
        94 =>
            array(
                'country_code' => 'HR',
                'country_name' => 'Croatia',
                'greeting' => 'Bok',
            ),
        95 =>
            array(
                'country_code' => 'HT',
                'country_name' => 'Haiti',
                'greeting' => 'Bonjour',
            ),
        96 =>
            array(
                'country_code' => 'HU',
                'country_name' => 'Hungary',
                'greeting' => 'Jó napot',
            ),
        97 =>
            array(
                'country_code' => 'ID',
                'country_name' => 'Indonesia',
                'greeting' => 'Selamat',
            ),
        98 =>
            array(
                'country_code' => 'IE',
                'country_name' => 'Ireland',
                'greeting' => 'Haileo',
            ),
        99 =>
            array(
                'country_code' => 'IL',
                'country_name' => 'Israel',
                'greeting' => 'Shalom',
            ),
        100 =>
            array(
                'country_code' => 'IM',
                'country_name' => 'Isle of Man',
                'greeting' => 'Hello',
            ),
        101 =>
            array(
                'country_code' => 'IN',
                'country_name' => 'India',
                'greeting' => '&#2344;&#2350;&#2360;&#2381;&#2340;&#2375;',
            ),
        102 =>
            array(
                'country_code' => 'IO',
                'country_name' => 'British Indian Ocean Territory',
                'greeting' => 'Hello',
            ),
        103 =>
            array(
                'country_code' => 'IQ',
                'country_name' => 'Iraq',
                'greeting' => 'Marhaba',
            ),
        104 =>
            array(
                'country_code' => 'IR',
                'country_name' => 'Iran  Islamic Republic of',
                'greeting' => 'Salâm',
            ),
        105 =>
            array(
                'country_code' => 'IS',
                'country_name' => 'Iceland',
                'greeting' => 'Góðan daginn',
            ),
        106 =>
            array(
                'country_code' => 'IT',
                'country_name' => 'Italy',
                'greeting' => 'Buon giorno',
            ),
        107 =>
            array(
                'country_code' => 'JE',
                'country_name' => 'Jersey',
                'greeting' => 'Hello',
            ),
        108 =>
            array(
                'country_code' => 'JM',
                'country_name' => 'Jamaica',
                'greeting' => 'Hello',
            ),
        109 =>
            array(
                'country_code' => 'JO',
                'country_name' => 'Jordan',
                'greeting' => 'Marhaba',
            ),
        110 =>
            array(
                'country_code' => 'JP',
                'country_name' => 'Japan',
                'greeting' => '&#12371;&#12435;&#12395;&#12385;&#12399;',
            ),
        111 =>
            array(
                'country_code' => 'KE',
                'country_name' => 'Kenya',
                'greeting' => 'Habari',
            ),
        112 =>
            array(
                'country_code' => 'KG',
                'country_name' => 'Kyrgyzstan',
                'greeting' => 'Kandisiz',
            ),
        113 =>
            array(
                'country_code' => 'KH',
                'country_name' => 'Cambodia',
                'greeting' => 'Sua s\'dei',
            ),
        114 =>
            array(
                'country_code' => 'KI',
                'country_name' => 'Kiribati',
                'greeting' => 'Mauri',
            ),
        115 =>
            array(
                'country_code' => 'KM',
                'country_name' => 'Comoros',
                'greeting' => 'Bariza djioni',
            ),
        116 =>
            array(
                'country_code' => 'KN',
                'country_name' => 'Saint Kitts and Nevis',
                'greeting' => 'Hello',
            ),
        117 =>
            array(
                'country_code' => 'KP',
                'country_name' => 'Korea  Democratic People\'s Republic of',
                'greeting' => '&#50504;&#45397;&#54616;&#49464;&#50836;',
            ),
        118 =>
            array(
                'country_code' => 'KR',
                'country_name' => 'Korea  Republic of',
                'greeting' => '&#50504;&#45397;&#54616;&#49464;&#50836;',
            ),
        119 =>
            array(
                'country_code' => 'KW',
                'country_name' => 'Kuwait',
                'greeting' => 'Marhaba',
            ),
        120 =>
            array(
                'country_code' => 'KY',
                'country_name' => 'Cayman Islands',
                'greeting' => 'Hello',
            ),
        121 =>
            array(
                'country_code' => 'KZ',
                'country_name' => 'Kazakhstan',
                'greeting' => 'Salam',
            ),
        122 =>
            array(
                'country_code' => 'LA',
                'country_name' => 'Lao People\'s Democratic Republic',
                'greeting' => 'Sabaidee',
            ),
        123 =>
            array(
                'country_code' => 'LB',
                'country_name' => 'Lebanon',
                'greeting' => 'Marhaba',
            ),
        124 =>
            array(
                'country_code' => 'LC',
                'country_name' => 'Saint Lucia',
                'greeting' => 'Hello',
            ),
        125 =>
            array(
                'country_code' => 'LI',
                'country_name' => 'Liechtenstein',
                'greeting' => 'Hallo',
            ),
        126 =>
            array(
                'country_code' => 'LK',
                'country_name' => 'Sri Lanka',
                'greeting' => 'A`yubowan',
            ),
        127 =>
            array(
                'country_code' => 'LR',
                'country_name' => 'Liberia',
                'greeting' => 'Hello',
            ),
        128 =>
            array(
                'country_code' => 'LS',
                'country_name' => 'Lesotho',
                'greeting' => 'Hello',
            ),
        129 =>
            array(
                'country_code' => 'LT',
                'country_name' => 'Lithuania',
                'greeting' => 'Laba diena',
            ),
        130 =>
            array(
                'country_code' => 'LU',
                'country_name' => 'Luxembourg',
                'greeting' => 'Moïen',
            ),
        131 =>
            array(
                'country_code' => 'LV',
                'country_name' => 'Latvia',
                'greeting' => 'Sveiki',
            ),
        132 =>
            array(
                'country_code' => 'LY',
                'country_name' => 'Libyan Arab Jamahiriya',
                'greeting' => 'Marhaba',
            ),
        133 =>
            array(
                'country_code' => 'MA',
                'country_name' => 'Morocco',
                'greeting' => 'Marhaba',
            ),
        134 =>
            array(
                'country_code' => 'MC',
                'country_name' => 'Monaco',
                'greeting' => 'Bonjour',
            ),
        135 =>
            array(
                'country_code' => 'MD',
                'country_name' => 'Moldova  Republic of',
                'greeting' => 'Salut',
            ),
        136 =>
            array(
                'country_code' => 'ME',
                'country_name' => 'Montenegro',
                'greeting' => 'Zdravo',
            ),
        137 =>
            array(
                'country_code' => 'MG',
                'country_name' => 'Madagascar',
                'greeting' => 'Manao ahoana',
            ),
        138 =>
            array(
                'country_code' => 'MH',
                'country_name' => 'Marshall Islands',
                'greeting' => 'Yokwe',
            ),
        139 =>
            array(
                'country_code' => 'MK',
                'country_name' => 'Macedonia',
                'greeting' => '&#1047;&#1076;&#1088;&#1072;&#1074;&#1086;',
            ),
        140 =>
            array(
                'country_code' => 'ML',
                'country_name' => 'Mali',
                'greeting' => 'Bonjour',
            ),
        141 =>
            array(
                'country_code' => 'MM',
                'country_name' => 'Myanmar',
                'greeting' => 'Mingalarba',
            ),
        142 =>
            array(
                'country_code' => 'MN',
                'country_name' => 'Mongolia',
                'greeting' => 'Sain baina uu',
            ),
        143 =>
            array(
                'country_code' => 'MO',
                'country_name' => 'Macao',
                'greeting' => '&#20320;&#22909;',
            ),
        144 =>
            array(
                'country_code' => 'MP',
                'country_name' => 'Northern Mariana Islands',
                'greeting' => 'Hello',
            ),
        145 =>
            array(
                'country_code' => 'MQ',
                'country_name' => 'Martinique',
                'greeting' => 'Hello',
            ),
        146 =>
            array(
                'country_code' => 'MR',
                'country_name' => 'Mauritania',
                'greeting' => 'Marhaba',
            ),
        147 =>
            array(
                'country_code' => 'MS',
                'country_name' => 'Montserrat',
                'greeting' => 'Hello',
            ),
        148 =>
            array(
                'country_code' => 'MT',
                'country_name' => 'Malta',
                'greeting' => 'Bongu',
            ),
        149 =>
            array(
                'country_code' => 'MU',
                'country_name' => 'Mauritius',
                'greeting' => 'Hello',
            ),
        150 =>
            array(
                'country_code' => 'MV',
                'country_name' => 'Maldives',
                'greeting' => 'Kihineth',
            ),
        151 =>
            array(
                'country_code' => 'MW',
                'country_name' => 'Malawi',
                'greeting' => 'Muribwanji',
            ),
        152 =>
            array(
                'country_code' => 'MX',
                'country_name' => 'Mexico',
                'greeting' => 'Hola',
            ),
        153 =>
            array(
                'country_code' => 'MY',
                'country_name' => 'Malaysia',
                'greeting' => 'Selamat',
            ),
        154 =>
            array(
                'country_code' => 'MZ',
                'country_name' => 'Mozambique',
                'greeting' => 'Olá',
            ),
        155 =>
            array(
                'country_code' => 'NA',
                'country_name' => 'Namibia',
                'greeting' => 'Hello',
            ),
        156 =>
            array(
                'country_code' => 'NC',
                'country_name' => 'New Caledonia',
                'greeting' => 'Bozo',
            ),
        157 =>
            array(
                'country_code' => 'NE',
                'country_name' => 'Niger',
                'greeting' => 'Bonjour',
            ),
        158 =>
            array(
                'country_code' => 'NF',
                'country_name' => 'Norfolk Island',
                'greeting' => 'Whataway',
            ),
        159 =>
            array(
                'country_code' => 'NG',
                'country_name' => 'Nigeria',
                'greeting' => 'Hello',
            ),
        160 =>
            array(
                'country_code' => 'NI',
                'country_name' => 'Nicaragua',
                'greeting' => 'Hola',
            ),
        161 =>
            array(
                'country_code' => 'NL',
                'country_name' => 'Netherlands',
                'greeting' => 'Hallo',
            ),
        162 =>
            array(
                'country_code' => 'NO',
                'country_name' => 'Norway',
                'greeting' => 'Hallo',
            ),
        163 =>
            array(
                'country_code' => 'NP',
                'country_name' => 'Nepal',
                'greeting' => 'Namaste',
            ),
        164 =>
            array(
                'country_code' => 'NR',
                'country_name' => 'Nauru',
                'greeting' => 'Hello',
            ),
        165 =>
            array(
                'country_code' => 'NU',
                'country_name' => 'Niue',
                'greeting' => 'Faka lofa lahi atu',
            ),
        166 =>
            array(
                'country_code' => 'NZ',
                'country_name' => 'New Zealand',
                'greeting' => 'Hello',
            ),
        167 =>
            array(
                'country_code' => 'OM',
                'country_name' => 'Oman',
                'greeting' => 'Marhaba',
            ),
        168 =>
            array(
                'country_code' => 'PA',
                'country_name' => 'Panama',
                'greeting' => 'Hola',
            ),
        169 =>
            array(
                'country_code' => 'PE',
                'country_name' => 'Peru',
                'greeting' => 'Hola',
            ),
        170 =>
            array(
                'country_code' => 'PF',
                'country_name' => 'French Polynesia',
                'greeting' => 'Bonjour',
            ),
        171 =>
            array(
                'country_code' => 'PG',
                'country_name' => 'Papua New Guinea',
                'greeting' => 'Hello',
            ),
        172 =>
            array(
                'country_code' => 'PH',
                'country_name' => 'Philippines',
                'greeting' => 'Halo',
            ),
        173 =>
            array(
                'country_code' => 'PK',
                'country_name' => 'Pakistan',
                'greeting' => 'Adaab',
            ),
        174 =>
            array(
                'country_code' => 'PL',
                'country_name' => 'Poland',
                'greeting' => 'Dzień dobry',
            ),
        175 =>
            array(
                'country_code' => 'PM',
                'country_name' => 'Saint Pierre and Miquelon',
                'greeting' => 'Hello',
            ),
        176 =>
            array(
                'country_code' => 'PR',
                'country_name' => 'Puerto Rico',
                'greeting' => 'Hola',
            ),
        177 =>
            array(
                'country_code' => 'PS',
                'country_name' => 'Palestinian Territory',
                'greeting' => 'Marhaba',
            ),
        178 =>
            array(
                'country_code' => 'PT',
                'country_name' => 'Portugal',
                'greeting' => 'Olá',
            ),
        179 =>
            array(
                'country_code' => 'PW',
                'country_name' => 'Palau',
                'greeting' => 'Alii',
            ),
        180 =>
            array(
                'country_code' => 'PY',
                'country_name' => 'Paraguay',
                'greeting' => 'Hola',
            ),
        181 =>
            array(
                'country_code' => 'QA',
                'country_name' => 'Qatar',
                'greeting' => 'Marhaba',
            ),
        182 =>
            array(
                'country_code' => 'RE',
                'country_name' => 'Reunion',
                'greeting' => 'Hello',
            ),
        183 =>
            array(
                'country_code' => 'RO',
                'country_name' => 'Romania',
                'greeting' => 'Salut',
            ),
        184 =>
            array(
                'country_code' => 'RS',
                'country_name' => 'Serbia',
                'greeting' => 'Zdravo',
            ),
        185 =>
            array(
                'country_code' => 'RU',
                'country_name' => 'Russian Federation',
                'greeting' => '&#1047;&#1076;&#1088;&#1072;&#1074;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;',
            ),
        186 =>
            array(
                'country_code' => 'RW',
                'country_name' => 'Rwanda',
                'greeting' => 'Hello',
            ),
        187 =>
            array(
                'country_code' => 'SA',
                'country_name' => 'Saudi Arabia',
                'greeting' => 'Marhaba',
            ),
        188 =>
            array(
                'country_code' => 'SB',
                'country_name' => 'Solomon Islands',
                'greeting' => 'Hello',
            ),
        189 =>
            array(
                'country_code' => 'SC',
                'country_name' => 'Seychelles',
                'greeting' => 'Hello',
            ),
        190 =>
            array(
                'country_code' => 'SD',
                'country_name' => 'Sudan',
                'greeting' => 'Marhaba',
            ),
        191 =>
            array(
                'country_code' => 'SE',
                'country_name' => 'Sweden',
                'greeting' => 'God dag',
            ),
        192 =>
            array(
                'country_code' => 'SG',
                'country_name' => 'Singapore',
                'greeting' => 'Selamat',
            ),
        193 =>
            array(
                'country_code' => 'SI',
                'country_name' => 'Slovenia',
                'greeting' => 'Živijo',
            ),
        194 =>
            array(
                'country_code' => 'SK',
                'country_name' => 'Slovakia',
                'greeting' => 'Dobrý deň',
            ),
        195 =>
            array(
                'country_code' => 'SL',
                'country_name' => 'Sierra Leone',
                'greeting' => 'Hello',
            ),
        196 =>
            array(
                'country_code' => 'SM',
                'country_name' => 'San Marino',
                'greeting' => 'Buon giorno',
            ),
        197 =>
            array(
                'country_code' => 'SN',
                'country_name' => 'Senegal',
                'greeting' => 'Bonjour',
            ),
        198 =>
            array(
                'country_code' => 'SO',
                'country_name' => 'Somalia',
                'greeting' => 'Maalim wanaqsan',
            ),
        199 =>
            array(
                'country_code' => 'SR',
                'country_name' => 'Suriname',
                'greeting' => 'Hallo',
            ),
        200 =>
            array(
                'country_code' => 'ST',
                'country_name' => 'Sao Tome and Principe',
                'greeting' => 'Hello',
            ),
        201 =>
            array(
                'country_code' => 'SV',
                'country_name' => 'El Salvador',
                'greeting' => 'Hola',
            ),
        202 =>
            array(
                'country_code' => 'SY',
                'country_name' => 'Syrian Arab Republic',
                'greeting' => 'Marhaba',
            ),
        203 =>
            array(
                'country_code' => 'SZ',
                'country_name' => 'Swaziland',
                'greeting' => 'Hello',
            ),
        204 =>
            array(
                'country_code' => 'TC',
                'country_name' => 'Turks and Caicos Islands',
                'greeting' => 'Hello',
            ),
        205 =>
            array(
                'country_code' => 'TD',
                'country_name' => 'Chad',
                'greeting' => 'Marhaba',
            ),
        206 =>
            array(
                'country_code' => 'TG',
                'country_name' => 'Togo',
                'greeting' => 'Bonjour',
            ),
        207 =>
            array(
                'country_code' => 'TH',
                'country_name' => 'Thailand',
                'greeting' => 'Sawatdi',
            ),
        208 =>
            array(
                'country_code' => 'TJ',
                'country_name' => 'Tajikistan',
                'greeting' => 'Salom',
            ),
        209 =>
            array(
                'country_code' => 'TK',
                'country_name' => 'Tokelau',
                'greeting' => 'Taloha',
            ),
        210 =>
            array(
                'country_code' => 'TM',
                'country_name' => 'Turkmenistan',
                'greeting' => 'Salam',
            ),
        211 =>
            array(
                'country_code' => 'TN',
                'country_name' => 'Tunisia',
                'greeting' => 'Marhaba',
            ),
        212 =>
            array(
                'country_code' => 'TO',
                'country_name' => 'Tonga',
                'greeting' => 'Malo e lelei',
            ),
        213 =>
            array(
                'country_code' => 'TR',
                'country_name' => 'Turkey',
                'greeting' => 'Merhaba',
            ),
        214 =>
            array(
                'country_code' => 'TT',
                'country_name' => 'Trinidad and Tobago',
                'greeting' => 'Hello',
            ),
        215 =>
            array(
                'country_code' => 'TV',
                'country_name' => 'Tuvalu',
                'greeting' => 'Talofa',
            ),
        216 =>
            array(
                'country_code' => 'TW',
                'country_name' => 'Taiwan',
                'greeting' => '&#20320;&#22909;',
            ),
        217 =>
            array(
                'country_code' => 'TZ',
                'country_name' => 'Tanzania  United Republic of',
                'greeting' => 'Habari',
            ),
        218 =>
            array(
                'country_code' => 'UA',
                'country_name' => 'Ukraine',
                'greeting' => 'Pryvit',
            ),
        219 =>
            array(
                'country_code' => 'UG',
                'country_name' => 'Uganda',
                'greeting' => 'Habari',
            ),
        220 =>
            array(
                'country_code' => 'UK',
                'country_name' => 'United Kingdom',
                'greeting' => 'Hello',
            ),
        221 =>
            array(
                'country_code' => 'UM',
                'country_name' => 'United States Minor Outlying Islands',
                'greeting' => 'Hello',
            ),
        222 =>
            array(
                'country_code' => 'US',
                'country_name' => 'United States',
                'greeting' => 'Hello',
            ),
        223 =>
            array(
                'country_code' => 'UY',
                'country_name' => 'Uruguay',
                'greeting' => 'Hola',
            ),
        224 =>
            array(
                'country_code' => 'UZ',
                'country_name' => 'Uzbekistan',
                'greeting' => 'Salom',
            ),
        225 =>
            array(
                'country_code' => 'VA',
                'country_name' => 'Holy See (Vatican City State)',
                'greeting' => 'Buon giorno',
            ),
        226 =>
            array(
                'country_code' => 'VC',
                'country_name' => 'Saint Vincent and the Grenadines',
                'greeting' => 'Hello',
            ),
        227 =>
            array(
                'country_code' => 'VE',
                'country_name' => 'Venezuela',
                'greeting' => 'Hola',
            ),
        228 =>
            array(
                'country_code' => 'VG',
                'country_name' => 'Virgin Islands  British',
                'greeting' => 'Hello',
            ),
        229 =>
            array(
                'country_code' => 'VI',
                'country_name' => 'Virgin Islands  U.S.',
                'greeting' => 'Hello',
            ),
        230 =>
            array(
                'country_code' => 'VN',
                'country_name' => 'Vietnam',
                'greeting' => 'Chào',
            ),
        231 =>
            array(
                'country_code' => 'VU',
                'country_name' => 'Vanuatu',
                'greeting' => 'Halo',
            ),
        232 =>
            array(
                'country_code' => 'WF',
                'country_name' => 'Wallis and Futuna',
                'greeting' => 'Malo le kataki',
            ),
        233 =>
            array(
                'country_code' => 'WS',
                'country_name' => 'Samoa',
                'greeting' => 'Talofa',
            ),
        234 =>
            array(
                'country_code' => 'YE',
                'country_name' => 'Yemen',
                'greeting' => 'Marhaba',
            ),
        235 =>
            array(
                'country_code' => 'YT',
                'country_name' => 'Mayotte',
                'greeting' => 'Hello',
            ),
        236 =>
            array(
                'country_code' => 'ZA',
                'country_name' => 'South Africa',
                'greeting' => 'Hello',
            ),
        237 =>
            array(
                'country_code' => 'ZM',
                'country_name' => 'Zambia',
                'greeting' => 'Hello',
            ),
        238 =>
            array(
                'country_code' => 'ZW',
                'country_name' => 'Zimbabwe',
                'greeting' => 'Hello',
            ),
        239 =>
            array(
                'country_code' => 'RD',
                'country_name' => 'Reserved',
                'greeting' => 'Hello',
            ),
    );

    return $welcomes[random_int(0, 239)];

}

