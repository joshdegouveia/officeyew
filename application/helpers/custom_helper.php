<?php

function getCountries ($code = '') {
	$countries = array(
	    1 => array(
	      "id" => 1,
	      "sortname" => "AF",
	      "name" => "Afghanistan",
	      "phoneCode" => 93
	    ),
	    2 => array(
	      "id" => 2,
	      "sortname" => "AL",
	      "name" => "Albania",
	      "phoneCode" => 355
	    ),
	    3 => array(
	      "id" => 3,
	      "sortname" => "DZ",
	      "name" => "Algeria",
	      "phoneCode" => 213
	    ),
	    4 => array(
	      "id" => 4,
	      "sortname" => "AS",
	      "name" => "American Samoa",
	      "phoneCode" => 1684
	    ),
	    5 => array(
	      "id" => 5,
	      "sortname" => "AD",
	      "name" => "Andorra",
	      "phoneCode" => 376
	    ),
	    6 => array(
	      "id" => 6,
	      "sortname" => "AO",
	      "name" => "Angola",
	      "phoneCode" => 244
	    ),
	    7 => array(
	      "id" => 7,
	      "sortname" => "AI",
	      "name" => "Anguilla",
	      "phoneCode" => 1264
	    ),
	    8 => array(
	      "id" => 8,
	      "sortname" => "AQ",
	      "name" => "Antarctica",
	      "phoneCode" => 0
	    ),
	    9 => array(
	      "id" => 9,
	      "sortname" => "AG",
	      "name" => "Antigua And Barbuda",
	      "phoneCode" => 1268
	    ),
	    10 => array(
	      "id" => 10,
	      "sortname" => "AR",
	      "name" => "Argentina",
	      "phoneCode" => 54
	    ),
	    11 => array(
	      "id" => 11,
	      "sortname" => "AM",
	      "name" => "Armenia",
	      "phoneCode" => 374
	    ),
	    12 => array(
	      "id" => 12,
	      "sortname" => "AW",
	      "name" => "Aruba",
	      "phoneCode" => 297
	    ),
	    13 => array(
	      "id" => 13,
	      "sortname" => "AU",
	      "name" => "Australia",
	      "phoneCode" => 61
	    ),
	    14 => array(
	      "id" => 14,
	      "sortname" => "AT",
	      "name" => "Austria",
	      "phoneCode" => 43
	    ),
	    15 => array(
	      "id" => 15,
	      "sortname" => "AZ",
	      "name" => "Azerbaijan",
	      "phoneCode" => 994
	    ),
	    16 => array(
	      "id" => 16,
	      "sortname" => "BS",
	      "name" => "Bahamas The",
	      "phoneCode" => 1242
	    ),
	    17 => array(
	      "id" => 17,
	      "sortname" => "BH",
	      "name" => "Bahrain",
	      "phoneCode" => 973
	    ),
	    18 => array(
	      "id" => 18,
	      "sortname" => "BD",
	      "name" => "Bangladesh",
	      "phoneCode" => 880
	    ),
	    19 => array(
	      "id" => 19,
	      "sortname" => "BB",
	      "name" => "Barbados",
	      "phoneCode" => 1246
	    ),
	    20 => array(
	      "id" => 20,
	      "sortname" => "BY",
	      "name" => "Belarus",
	      "phoneCode" => 375
	    ),
	    21 => array(
	      "id" => 21,
	      "sortname" => "BE",
	      "name" => "Belgium",
	      "phoneCode" => 32
	    ),
	    22 => array(
	      "id" => 22,
	      "sortname" => "BZ",
	      "name" => "Belize",
	      "phoneCode" => 501
	    ),
	    23 => array(
	      "id" => 23,
	      "sortname" => "BJ",
	      "name" => "Benin",
	      "phoneCode" => 229
	    ),
	    24 => array(
	      "id" => 24,
	      "sortname" => "BM",
	      "name" => "Bermuda",
	      "phoneCode" => 1441
	    ),
	    25 => array(
	      "id" => 25,
	      "sortname" => "BT",
	      "name" => "Bhutan",
	      "phoneCode" => 975
	    ),
	    26 => array(
	      "id" => 26,
	      "sortname" => "BO",
	      "name" => "Bolivia",
	      "phoneCode" => 591
	    ),
	    27 => array(
	      "id" => 27,
	      "sortname" => "BA",
	      "name" => "Bosnia and Herzegovina",
	      "phoneCode" => 387
	    ),
	    28 => array(
	      "id" => 28,
	      "sortname" => "BW",
	      "name" => "Botswana",
	      "phoneCode" => 267
	    ),
	    29 => array(
	      "id" => 29,
	      "sortname" => "BV",
	      "name" => "Bouvet Island",
	      "phoneCode" => 0
	    ),
	    30 => array(
	      "id" => 30,
	      "sortname" => "BR",
	      "name" => "Brazil",
	      "phoneCode" => 55
	    ),
	    31 => array(
	      "id" => 31,
	      "sortname" => "IO",
	      "name" => "British Indian Ocean Territory",
	      "phoneCode" => 246
	    ),
	    32 => array(
	      "id" => 32,
	      "sortname" => "BN",
	      "name" => "Brunei",
	      "phoneCode" => 673
	    ),
	    33 => array(
	      "id" => 33,
	      "sortname" => "BG",
	      "name" => "Bulgaria",
	      "phoneCode" => 359
	    ),
	    34 => array(
	      "id" => 34,
	      "sortname" => "BF",
	      "name" => "Burkina Faso",
	      "phoneCode" => 226
	    ),
	    35 => array(
	      "id" => 35,
	      "sortname" => "BI",
	      "name" => "Burundi",
	      "phoneCode" => 257
	    ),
	    36 => array(
	      "id" => 36,
	      "sortname" => "KH",
	      "name" => "Cambodia",
	      "phoneCode" => 855
	    ),
	    37 => array(
	      "id" => 37,
	      "sortname" => "CM",
	      "name" => "Cameroon",
	      "phoneCode" => 237
	    ),
	    38 => array(
	      "id" => 38,
	      "sortname" => "CA",
	      "name" => "Canada",
	      "phoneCode" => 1
	    ),
	    39 => array(
	      "id" => 39,
	      "sortname" => "CV",
	      "name" => "Cape Verde",
	      "phoneCode" => 238
	    ),
	    40 => array(
	      "id" => 40,
	      "sortname" => "KY",
	      "name" => "Cayman Islands",
	      "phoneCode" => 1345
	    ),
	    41 => array(
	      "id" => 41,
	      "sortname" => "CF",
	      "name" => "Central African Republic",
	      "phoneCode" => 236
	    ),
	    42 => array(
	      "id" => 42,
	      "sortname" => "TD",
	      "name" => "Chad",
	      "phoneCode" => 235
	    ),
	    43 => array(
	      "id" => 43,
	      "sortname" => "CL",
	      "name" => "Chile",
	      "phoneCode" => 56
	    ),
	    44 => array(
	      "id" => 44,
	      "sortname" => "CN",
	      "name" => "China",
	      "phoneCode" => 86
	    ),
	    45 => array(
	      "id" => 45,
	      "sortname" => "CX",
	      "name" => "Christmas Island",
	      "phoneCode" => 61
	    ),
	    46 => array(
	      "id" => 46,
	      "sortname" => "CC",
	      "name" => "Cocos (Keeling) Islands",
	      "phoneCode" => 672
	    ),
	    47 => array(
	      "id" => 47,
	      "sortname" => "CO",
	      "name" => "Colombia",
	      "phoneCode" => 57
	    ),
	    48 => array(
	      "id" => 48,
	      "sortname" => "KM",
	      "name" => "Comoros",
	      "phoneCode" => 269
	    ),
	    49 => array(
	      "id" => 49,
	      "sortname" => "CG",
	      "name" => "Republic Of The Congo",
	      "phoneCode" => 242
	    ),
	    50 => array(
	      "id" => 50,
	      "sortname" => "CD",
	      "name" => "Democratic Republic Of The Congo",
	      "phoneCode" => 242
	    ),
	    51 => array(
	      "id" => 51,
	      "sortname" => "CK",
	      "name" => "Cook Islands",
	      "phoneCode" => 682
	    ),
	    52 => array(
	      "id" => 52,
	      "sortname" => "CR",
	      "name" => "Costa Rica",
	      "phoneCode" => 506
	    ),
	    53 => array(
	      "id" => 53,
	      "sortname" => "CI",
	      "name" => "Cote D''Ivoire (Ivory Coast)",
	      "phoneCode" => 225
	    ),
	    54 => array(
	      "id" => 54,
	      "sortname" => "HR",
	      "name" => "Croatia (Hrvatska)",
	      "phoneCode" => 385
	    ),
	    55 => array(
	      "id" => 55,
	      "sortname" => "CU",
	      "name" => "Cuba",
	      "phoneCode" => 53
	    ),
	    56 => array(
	      "id" => 56,
	      "sortname" => "CY",
	      "name" => "Cyprus",
	      "phoneCode" => 357
	    ),
	    57 => array(
	      "id" => 57,
	      "sortname" => "CZ",
	      "name" => "Czech Republic",
	      "phoneCode" => 420
	    ),
	    58 => array(
	      "id" => 58,
	      "sortname" => "DK",
	      "name" => "Denmark",
	      "phoneCode" => 45
	    ),
	    59 => array(
	      "id" => 59,
	      "sortname" => "DJ",
	      "name" => "Djibouti",
	      "phoneCode" => 253
	    ),
	    60 => array(
	      "id" => 60,
	      "sortname" => "DM",
	      "name" => "Dominica",
	      "phoneCode" => 1767
	    ),
	    61 => array(
	      "id" => 61,
	      "sortname" => "DO",
	      "name" => "Dominican Republic",
	      "phoneCode" => 1809
	    ),
	    62 => array(
	      "id" => 62,
	      "sortname" => "TP",
	      "name" => "East Timor",
	      "phoneCode" => 670
	    ),
	    63 => array(
	      "id" => 63,
	      "sortname" => "EC",
	      "name" => "Ecuador",
	      "phoneCode" => 593
	    ),
	    64 => array(
	      "id" => 64,
	      "sortname" => "EG",
	      "name" => "Egypt",
	      "phoneCode" => 20
	    ),
	    65 => array(
	      "id" => 65,
	      "sortname" => "SV",
	      "name" => "El Salvador",
	      "phoneCode" => 503
	    ),
	    66 => array(
	      "id" => 66,
	      "sortname" => "GQ",
	      "name" => "Equatorial Guinea",
	      "phoneCode" => 240
	    ),
	    67 => array(
	      "id" => 67,
	      "sortname" => "ER",
	      "name" => "Eritrea",
	      "phoneCode" => 291
	    ),
	    68 => array(
	      "id" => 68,
	      "sortname" => "EE",
	      "name" => "Estonia",
	      "phoneCode" => 372
	    ),
	    69 => array(
	      "id" => 69,
	      "sortname" => "ET",
	      "name" => "Ethiopia",
	      "phoneCode" => 251
	    ),
	    70 => array(
	      "id" => 70,
	      "sortname" => "XA",
	      "name" => "External Territories of Australia",
	      "phoneCode" => 61
	    ),
	    71 => array(
	      "id" => 71,
	      "sortname" => "FK",
	      "name" => "Falkland Islands",
	      "phoneCode" => 500
	    ),
	    72 => array(
	      "id" => 72,
	      "sortname" => "FO",
	      "name" => "Faroe Islands",
	      "phoneCode" => 298
	    ),
	    73 => array(
	      "id" => 73,
	      "sortname" => "FJ",
	      "name" => "Fiji Islands",
	      "phoneCode" => 679
	    ),
	    74 => array(
	      "id" => 74,
	      "sortname" => "FI",
	      "name" => "Finland",
	      "phoneCode" => 358
	    ),
	    75 => array(
	      "id" => 75,
	      "sortname" => "FR",
	      "name" => "France",
	      "phoneCode" => 33
	    ),
	    76 => array(
	      "id" => 76,
	      "sortname" => "GF",
	      "name" => "French Guiana",
	      "phoneCode" => 594
	    ),
	    77 => array(
	      "id" => 77,
	      "sortname" => "PF",
	      "name" => "French Polynesia",
	      "phoneCode" => 689
	    ),
	    78 => array(
	      "id" => 78,
	      "sortname" => "TF",
	      "name" => "French Southern Territories",
	      "phoneCode" => 0
	    ),
	    79 => array(
	      "id" => 79,
	      "sortname" => "GA",
	      "name" => "Gabon",
	      "phoneCode" => 241
	    ),
	    80 => array(
	      "id" => 80,
	      "sortname" => "GM",
	      "name" => "Gambia The",
	      "phoneCode" => 220
	    ),
	    81 => array(
	      "id" => 81,
	      "sortname" => "GE",
	      "name" => "Georgia",
	      "phoneCode" => 995
	    ),
	    82 => array(
	      "id" => 82,
	      "sortname" => "DE",
	      "name" => "Germany",
	      "phoneCode" => 49
	    ),
	    83 => array(
	      "id" => 83,
	      "sortname" => "GH",
	      "name" => "Ghana",
	      "phoneCode" => 233
	    ),
	    84 => array(
	      "id" => 84,
	      "sortname" => "GI",
	      "name" => "Gibraltar",
	      "phoneCode" => 350
	    ),
	    85 => array(
	      "id" => 85,
	      "sortname" => "GR",
	      "name" => "Greece",
	      "phoneCode" => 30
	    ),
	    86 => array(
	      "id" => 86,
	      "sortname" => "GL",
	      "name" => "Greenland",
	      "phoneCode" => 299
	    ),
	    87 => array(
	      "id" => 87,
	      "sortname" => "GD",
	      "name" => "Grenada",
	      "phoneCode" => 1473
	    ),
	    88 => array(
	      "id" => 88,
	      "sortname" => "GP",
	      "name" => "Guadeloupe",
	      "phoneCode" => 590
	    ),
	    89 => array(
	      "id" => 89,
	      "sortname" => "GU",
	      "name" => "Guam",
	      "phoneCode" => 1671
	    ),
	    90 => array(
	      "id" => 90,
	      "sortname" => "GT",
	      "name" => "Guatemala",
	      "phoneCode" => 502
	    ),
	    91 => array(
	      "id" => 91,
	      "sortname" => "XU",
	      "name" => "Guernsey and Alderney",
	      "phoneCode" => 44
	    ),
	    92 => array(
	      "id" => 92,
	      "sortname" => "GN",
	      "name" => "Guinea",
	      "phoneCode" => 224
	    ),
	    93 => array(
	      "id" => 93,
	      "sortname" => "GW",
	      "name" => "Guinea-Bissau",
	      "phoneCode" => 245
	    ),
	    94 => array(
	      "id" => 94,
	      "sortname" => "GY",
	      "name" => "Guyana",
	      "phoneCode" => 592
	    ),
	    95 => array(
	      "id" => 95,
	      "sortname" => "HT",
	      "name" => "Haiti",
	      "phoneCode" => 509
	    ),
	    96 => array(
	      "id" => 96,
	      "sortname" => "HM",
	      "name" => "Heard and McDonald Islands",
	      "phoneCode" => 0
	    ),
	    97 => array(
	      "id" => 97,
	      "sortname" => "HN",
	      "name" => "Honduras",
	      "phoneCode" => 504
	    ),
	    98 => array(
	      "id" => 98,
	      "sortname" => "HK",
	      "name" => "Hong Kong S.A.R.",
	      "phoneCode" => 852
	    ),
	    99 => array(
	      "id" => 99,
	      "sortname" => "HU",
	      "name" => "Hungary",
	      "phoneCode" => 36
	    ),
	    100 => array(
	      "id" => 100,
	      "sortname" => "IS",
	      "name" => "Iceland",
	      "phoneCode" => 354
	    ),
	    101 => array(
	      "id" => 101,
	      "sortname" => "IN",
	      "name" => "India",
	      "phoneCode" => 91
	    ),
	    102 => array(
	      "id" => 102,
	      "sortname" => "ID",
	      "name" => "Indonesia",
	      "phoneCode" => 62
	    ),
	    103 => array(
	      "id" => 103,
	      "sortname" => "IR",
	      "name" => "Iran",
	      "phoneCode" => 98
	    ),
	    104 => array(
	      "id" => 104,
	      "sortname" => "IQ",
	      "name" => "Iraq",
	      "phoneCode" => 964
	    ),
	    105 => array(
	      "id" => 105,
	      "sortname" => "IE",
	      "name" => "Ireland",
	      "phoneCode" => 353
	    ),
	    106 => array(
	      "id" => 106,
	      "sortname" => "IL",
	      "name" => "Israel",
	      "phoneCode" => 972
	    ),
	    107 => array(
	      "id" => 107,
	      "sortname" => "IT",
	      "name" => "Italy",
	      "phoneCode" => 39
	    ),
	    108 => array(
	      "id" => 108,
	      "sortname" => "JM",
	      "name" => "Jamaica",
	      "phoneCode" => 1876
	    ),
	    109 => array(
	      "id" => 109,
	      "sortname" => "JP",
	      "name" => "Japan",
	      "phoneCode" => 81
	    ),
	    110 => array(
	      "id" => 110,
	      "sortname" => "XJ",
	      "name" => "Jersey",
	      "phoneCode" => 44
	    ),
	    111 => array(
	      "id" => 111,
	      "sortname" => "JO",
	      "name" => "Jordan",
	      "phoneCode" => 962
	    ),
	    112 => array(
	      "id" => 112,
	      "sortname" => "KZ",
	      "name" => "Kazakhstan",
	      "phoneCode" => 7
	    ),
	    113 => array(
	      "id" => 113,
	      "sortname" => "KE",
	      "name" => "Kenya",
	      "phoneCode" => 254
	    ),
	    114 => array(
	      "id" => 114,
	      "sortname" => "KI",
	      "name" => "Kiribati",
	      "phoneCode" => 686
	    ),
	    115 => array(
	      "id" => 115,
	      "sortname" => "KP",
	      "name" => "Korea North",
	      "phoneCode" => 850
	    ),
	    116 => array(
	      "id" => 116,
	      "sortname" => "KR",
	      "name" => "Korea South",
	      "phoneCode" => 82
	    ),
	    117 => array(
	      "id" => 117,
	      "sortname" => "KW",
	      "name" => "Kuwait",
	      "phoneCode" => 965
	    ),
	    118 => array(
	      "id" => 118,
	      "sortname" => "KG",
	      "name" => "Kyrgyzstan",
	      "phoneCode" => 996
	    ),
	    119 => array(
	      "id" => 119,
	      "sortname" => "LA",
	      "name" => "Laos",
	      "phoneCode" => 856
	    ),
	    120 => array(
	      "id" => 120,
	      "sortname" => "LV",
	      "name" => "Latvia",
	      "phoneCode" => 371
	    ),
	    121 => array(
	      "id" => 121,
	      "sortname" => "LB",
	      "name" => "Lebanon",
	      "phoneCode" => 961
	    ),
	    122 => array(
	      "id" => 122,
	      "sortname" => "LS",
	      "name" => "Lesotho",
	      "phoneCode" => 266
	    ),
	    123 => array(
	      "id" => 123,
	      "sortname" => "LR",
	      "name" => "Liberia",
	      "phoneCode" => 231
	    ),
	    124 => array(
	      "id" => 124,
	      "sortname" => "LY",
	      "name" => "Libya",
	      "phoneCode" => 218
	    ),
	    125 => array(
	      "id" => 125,
	      "sortname" => "LI",
	      "name" => "Liechtenstein",
	      "phoneCode" => 423
	    ),
	    126 => array(
	      "id" => 126,
	      "sortname" => "LT",
	      "name" => "Lithuania",
	      "phoneCode" => 370
	    ),
	    127 => array(
	      "id" => 127,
	      "sortname" => "LU",
	      "name" => "Luxembourg",
	      "phoneCode" => 352
	    ),
	    128 => array(
	      "id" => 128,
	      "sortname" => "MO",
	      "name" => "Macau S.A.R.",
	      "phoneCode" => 853
	    ),
	    129 => array(
	      "id" => 129,
	      "sortname" => "MK",
	      "name" => "Macedonia",
	      "phoneCode" => 389
	    ),
	    130 => array(
	      "id" => 130,
	      "sortname" => "MG",
	      "name" => "Madagascar",
	      "phoneCode" => 261
	    ),
	    131 => array(
	      "id" => 131,
	      "sortname" => "MW",
	      "name" => "Malawi",
	      "phoneCode" => 265
	    ),
	    132 => array(
	      "id" => 132,
	      "sortname" => "MY",
	      "name" => "Malaysia",
	      "phoneCode" => 60
	    ),
	    133 => array(
	      "id" => 133,
	      "sortname" => "MV",
	      "name" => "Maldives",
	      "phoneCode" => 960
	    ),
	    134 => array(
	      "id" => 134,
	      "sortname" => "ML",
	      "name" => "Mali",
	      "phoneCode" => 223
	    ),
	    135 => array(
	      "id" => 135,
	      "sortname" => "MT",
	      "name" => "Malta",
	      "phoneCode" => 356
	    ),
	    136 => array(
	      "id" => 136,
	      "sortname" => "XM",
	      "name" => "Man (Isle of)",
	      "phoneCode" => 44
	    ),
	    137 => array(
	      "id" => 137,
	      "sortname" => "MH",
	      "name" => "Marshall Islands",
	      "phoneCode" => 692
	    ),
	    138 => array(
	      "id" => 138,
	      "sortname" => "MQ",
	      "name" => "Martinique",
	      "phoneCode" => 596
	    ),
	    139 => array(
	      "id" => 139,
	      "sortname" => "MR",
	      "name" => "Mauritania",
	      "phoneCode" => 222
	    ),
	    140 => array(
	      "id" => 140,
	      "sortname" => "MU",
	      "name" => "Mauritius",
	      "phoneCode" => 230
	    ),
	    141 => array(
	      "id" => 141,
	      "sortname" => "YT",
	      "name" => "Mayotte",
	      "phoneCode" => 269
	    ),
	    142 => array(
	      "id" => 142,
	      "sortname" => "MX",
	      "name" => "Mexico",
	      "phoneCode" => 52
	    ),
	    143 => array(
	      "id" => 143,
	      "sortname" => "FM",
	      "name" => "Micronesia",
	      "phoneCode" => 691
	    ),
	    144 => array(
	      "id" => 144,
	      "sortname" => "MD",
	      "name" => "Moldova",
	      "phoneCode" => 373
	    ),
	    145 => array(
	      "id" => 145,
	      "sortname" => "MC",
	      "name" => "Monaco",
	      "phoneCode" => 377
	    ),
	    146 => array(
	      "id" => 146,
	      "sortname" => "MN",
	      "name" => "Mongolia",
	      "phoneCode" => 976
	    ),
	    147 => array(
	      "id" => 147,
	      "sortname" => "MS",
	      "name" => "Montserrat",
	      "phoneCode" => 1664
	    ),
	    148 => array(
	      "id" => 148,
	      "sortname" => "MA",
	      "name" => "Morocco",
	      "phoneCode" => 212
	    ),
	    149 => array(
	      "id" => 149,
	      "sortname" => "MZ",
	      "name" => "Mozambique",
	      "phoneCode" => 258
	    ),
	    150 => array(
	      "id" => 150,
	      "sortname" => "MM",
	      "name" => "Myanmar",
	      "phoneCode" => 95
	    ),
	    151 => array(
	      "id" => 151,
	      "sortname" => "NA",
	      "name" => "Namibia",
	      "phoneCode" => 264
	    ),
	    152 => array(
	      "id" => 152,
	      "sortname" => "NR",
	      "name" => "Nauru",
	      "phoneCode" => 674
	    ),
	    153 => array(
	      "id" => 153,
	      "sortname" => "NP",
	      "name" => "Nepal",
	      "phoneCode" => 977
	    ),
	    154 => array(
	      "id" => 154,
	      "sortname" => "AN",
	      "name" => "Netherlands Antilles",
	      "phoneCode" => 599
	    ),
	    155 => array(
	      "id" => 155,
	      "sortname" => "NL",
	      "name" => "Netherlands The",
	      "phoneCode" => 31
	    ),
	    156 => array(
	      "id" => 156,
	      "sortname" => "NC",
	      "name" => "New Caledonia",
	      "phoneCode" => 687
	    ),
	    157 => array(
	      "id" => 157,
	      "sortname" => "NZ",
	      "name" => "New Zealand",
	      "phoneCode" => 64
	    ),
	    158 => array(
	      "id" => 158,
	      "sortname" => "NI",
	      "name" => "Nicaragua",
	      "phoneCode" => 505
	    ),
	    159 => array(
	      "id" => 159,
	      "sortname" => "NE",
	      "name" => "Niger",
	      "phoneCode" => 227
	    ),
	    160 => array(
	      "id" => 160,
	      "sortname" => "NG",
	      "name" => "Nigeria",
	      "phoneCode" => 234
	    ),
	    161 => array(
	      "id" => 161,
	      "sortname" => "NU",
	      "name" => "Niue",
	      "phoneCode" => 683
	    ),
	    162 => array(
	      "id" => 162,
	      "sortname" => "NF",
	      "name" => "Norfolk Island",
	      "phoneCode" => 672
	    ),
	    163 => array(
	      "id" => 163,
	      "sortname" => "MP",
	      "name" => "Northern Mariana Islands",
	      "phoneCode" => 1670
	    ),
	    164 => array(
	      "id" => 164,
	      "sortname" => "NO",
	      "name" => "Norway",
	      "phoneCode" => 47
	    ),
	    165 => array(
	      "id" => 165,
	      "sortname" => "OM",
	      "name" => "Oman",
	      "phoneCode" => 968
	    ),
	    166 => array(
	      "id" => 166,
	      "sortname" => "PK",
	      "name" => "Pakistan",
	      "phoneCode" => 92
	    ),
	    167 => array(
	      "id" => 167,
	      "sortname" => "PW",
	      "name" => "Palau",
	      "phoneCode" => 680
	    ),
	    168 => array(
	      "id" => 168,
	      "sortname" => "PS",
	      "name" => "Palestinian Territory Occupied",
	      "phoneCode" => 970
	    ),
	    169 => array(
	      "id" => 169,
	      "sortname" => "PA",
	      "name" => "Panama",
	      "phoneCode" => 507
	    ),
	    170 => array(
	      "id" => 170,
	      "sortname" => "PG",
	      "name" => "Papua new Guinea",
	      "phoneCode" => 675
	    ),
	    171 => array(
	      "id" => 171,
	      "sortname" => "PY",
	      "name" => "Paraguay",
	      "phoneCode" => 595
	    ),
	    172 => array(
	      "id" => 172,
	      "sortname" => "PE",
	      "name" => "Peru",
	      "phoneCode" => 51
	    ),
	    173 => array(
	      "id" => 173,
	      "sortname" => "PH",
	      "name" => "Philippines",
	      "phoneCode" => 63
	    ),
	    174 => array(
	      "id" => 174,
	      "sortname" => "PN",
	      "name" => "Pitcairn Island",
	      "phoneCode" => 0
	    ),
	    175 => array(
	      "id" => 175,
	      "sortname" => "PL",
	      "name" => "Poland",
	      "phoneCode" => 48
	    ),
	    176 => array(
	      "id" => 176,
	      "sortname" => "PT",
	      "name" => "Portugal",
	      "phoneCode" => 351
	    ),
	    177 => array(
	      "id" => 177,
	      "sortname" => "PR",
	      "name" => "Puerto Rico",
	      "phoneCode" => 1787
	    ),
	    178 => array(
	      "id" => 178,
	      "sortname" => "QA",
	      "name" => "Qatar",
	      "phoneCode" => 974
	    ),
	    179 => array(
	      "id" => 179,
	      "sortname" => "RE",
	      "name" => "Reunion",
	      "phoneCode" => 262
	    ),
	    180 => array(
	      "id" => 180,
	      "sortname" => "RO",
	      "name" => "Romania",
	      "phoneCode" => 40
	    ),
	    181 => array(
	      "id" => 181,
	      "sortname" => "RU",
	      "name" => "Russia",
	      "phoneCode" => 70
	    ),
	    182 => array(
	      "id" => 182,
	      "sortname" => "RW",
	      "name" => "Rwanda",
	      "phoneCode" => 250
	    ),
	    183 => array(
	      "id" => 183,
	      "sortname" => "SH",
	      "name" => "Saint Helena",
	      "phoneCode" => 290
	    ),
	    184 => array(
	      "id" => 184,
	      "sortname" => "KN",
	      "name" => "Saint Kitts And Nevis",
	      "phoneCode" => 1869
	    ),
	    185 => array(
	      "id" => 185,
	      "sortname" => "LC",
	      "name" => "Saint Lucia",
	      "phoneCode" => 1758
	    ),
	    186 => array(
	      "id" => 186,
	      "sortname" => "PM",
	      "name" => "Saint Pierre and Miquelon",
	      "phoneCode" => 508
	    ),
	    187 => array(
	      "id" => 187,
	      "sortname" => "VC",
	      "name" => "Saint Vincent And The Grenadines",
	      "phoneCode" => 1784
	    ),
	    188 => array(
	      "id" => 188,
	      "sortname" => "WS",
	      "name" => "Samoa",
	      "phoneCode" => 684
	    ),
	    189 => array(
	      "id" => 189,
	      "sortname" => "SM",
	      "name" => "San Marino",
	      "phoneCode" => 378
	    ),
	    190 => array(
	      "id" => 190,
	      "sortname" => "ST",
	      "name" => "Sao Tome and Principe",
	      "phoneCode" => 239
	    ),
	    191 => array(
	      "id" => 191,
	      "sortname" => "SA",
	      "name" => "Saudi Arabia",
	      "phoneCode" => 966
	    ),
	    192 => array(
	      "id" => 192,
	      "sortname" => "SN",
	      "name" => "Senegal",
	      "phoneCode" => 221
	    ),
	    193 => array(
	      "id" => 193,
	      "sortname" => "RS",
	      "name" => "Serbia",
	      "phoneCode" => 381
	    ),
	    194 => array(
	      "id" => 194,
	      "sortname" => "SC",
	      "name" => "Seychelles",
	      "phoneCode" => 248
	    ),
	    195 => array(
	      "id" => 195,
	      "sortname" => "SL",
	      "name" => "Sierra Leone",
	      "phoneCode" => 232
	    ),
	    196 => array(
	      "id" => 196,
	      "sortname" => "SG",
	      "name" => "Singapore",
	      "phoneCode" => 65
	    ),
	    197 => array(
	      "id" => 197,
	      "sortname" => "SK",
	      "name" => "Slovakia",
	      "phoneCode" => 421
	    ),
	    198 => array(
	      "id" => 198,
	      "sortname" => "SI",
	      "name" => "Slovenia",
	      "phoneCode" => 386
	    ),
	    199 => array(
	      "id" => 199,
	      "sortname" => "XG",
	      "name" => "Smaller Territories of the UK",
	      "phoneCode" => 44
	    ),
	    200 => array(
	      "id" => 200,
	      "sortname" => "SB",
	      "name" => "Solomon Islands",
	      "phoneCode" => 677
	    ),
	    201 => array(
	      "id" => 201,
	      "sortname" => "SO",
	      "name" => "Somalia",
	      "phoneCode" => 252
	    ),
	    202 => array(
	      "id" => 202,
	      "sortname" => "ZA",
	      "name" => "South Africa",
	      "phoneCode" => 27
	    ),
	    203 => array(
	      "id" => 203,
	      "sortname" => "GS",
	      "name" => "South Georgia",
	      "phoneCode" => 0
	    ),
	    204 => array(
	      "id" => 204,
	      "sortname" => "SS",
	      "name" => "South Sudan",
	      "phoneCode" => 211
	    ),
	    205 => array(
	      "id" => 205,
	      "sortname" => "ES",
	      "name" => "Spain",
	      "phoneCode" => 34
	    ),
	    206 => array(
	      "id" => 206,
	      "sortname" => "LK",
	      "name" => "Sri Lanka",
	      "phoneCode" => 94
	    ),
	    207 => array(
	      "id" => 207,
	      "sortname" => "SD",
	      "name" => "Sudan",
	      "phoneCode" => 249
	    ),
	    208 => array(
	      "id" => 208,
	      "sortname" => "SR",
	      "name" => "Suriname",
	      "phoneCode" => 597
	    ),
	    209 => array(
	      "id" => 209,
	      "sortname" => "SJ",
	      "name" => "Svalbard And Jan Mayen Islands",
	      "phoneCode" => 47
	    ),
	    210 => array(
	      "id" => 210,
	      "sortname" => "SZ",
	      "name" => "Swaziland",
	      "phoneCode" => 268
	    ),
	    211 => array(
	      "id" => 211,
	      "sortname" => "SE",
	      "name" => "Sweden",
	      "phoneCode" => 46
	    ),
	    212 => array(
	      "id" => 212,
	      "sortname" => "CH",
	      "name" => "Switzerland",
	      "phoneCode" => 41
	    ),
	    213 => array(
	      "id" => 213,
	      "sortname" => "SY",
	      "name" => "Syria",
	      "phoneCode" => 963
	    ),
	    214 => array(
	      "id" => 214,
	      "sortname" => "TW",
	      "name" => "Taiwan",
	      "phoneCode" => 886
	    ),
	    215 => array(
	      "id" => 215,
	      "sortname" => "TJ",
	      "name" => "Tajikistan",
	      "phoneCode" => 992
	    ),
	    216 => array(
	      "id" => 216,
	      "sortname" => "TZ",
	      "name" => "Tanzania",
	      "phoneCode" => 255
	    ),
	    217 => array(
	      "id" => 217,
	      "sortname" => "TH",
	      "name" => "Thailand",
	      "phoneCode" => 66
	    ),
	    218 => array(
	      "id" => 218,
	      "sortname" => "TG",
	      "name" => "Togo",
	      "phoneCode" => 228
	    ),
	    219 => array(
	      "id" => 219,
	      "sortname" => "TK",
	      "name" => "Tokelau",
	      "phoneCode" => 690
	    ),
	    220 => array(
	      "id" => 220,
	      "sortname" => "TO",
	      "name" => "Tonga",
	      "phoneCode" => 676
	    ),
	    221 => array(
	      "id" => 221,
	      "sortname" => "TT",
	      "name" => "Trinidad And Tobago",
	      "phoneCode" => 1868
	    ),
	    222 => array(
	      "id" => 222,
	      "sortname" => "TN",
	      "name" => "Tunisia",
	      "phoneCode" => 216
	    ),
	    223 => array(
	      "id" => 223,
	      "sortname" => "TR",
	      "name" => "Turkey",
	      "phoneCode" => 90
	    ),
	    224 => array(
	      "id" => 224,
	      "sortname" => "TM",
	      "name" => "Turkmenistan",
	      "phoneCode" => 7370
	    ),
	    225 => array(
	      "id" => 225,
	      "sortname" => "TC",
	      "name" => "Turks And Caicos Islands",
	      "phoneCode" => 1649
	    ),
	    226 => array(
	      "id" => 226,
	      "sortname" => "TV",
	      "name" => "Tuvalu",
	      "phoneCode" => 688
	    ),
	    227 => array(
	      "id" => 227,
	      "sortname" => "UG",
	      "name" => "Uganda",
	      "phoneCode" => 256
	    ),
	    228 => array(
	      "id" => 228,
	      "sortname" => "UA",
	      "name" => "Ukraine",
	      "phoneCode" => 380
	    ),
	    229 => array(
	      "id" => 229,
	      "sortname" => "AE",
	      "name" => "United Arab Emirates",
	      "phoneCode" => 971
	    ),
	    230 => array(
	      "id" => 230,
	      "sortname" => "GB",
	      "name" => "United Kingdom",
	      "phoneCode" => 44
	    ),
	    231 => array(
	      "id" => 231,
	      "sortname" => "US",
	      "name" => "United States",
	      "phoneCode" => 1
	    ),
	    232 => array(
	      "id" => 232,
	      "sortname" => "UM",
	      "name" => "United States Minor Outlying Islands",
	      "phoneCode" => 1
	    ),
	    233 => array(
	      "id" => 233,
	      "sortname" => "UY",
	      "name" => "Uruguay",
	      "phoneCode" => 598
	    ),
	    234 => array(
	      "id" => 234,
	      "sortname" => "UZ",
	      "name" => "Uzbekistan",
	      "phoneCode" => 998
	    ),
	    235 => array(
	      "id" => 235,
	      "sortname" => "VU",
	      "name" => "Vanuatu",
	      "phoneCode" => 678
	    ),
	    236 => array(
	      "id" => 236,
	      "sortname" => "VA",
	      "name" => "Vatican City State (Holy See)",
	      "phoneCode" => 39
	    ),
	    237 => array(
	      "id" => 237,
	      "sortname" => "VE",
	      "name" => "Venezuela",
	      "phoneCode" => 58
	    ),
	    238 => array(
	      "id" => 238,
	      "sortname" => "VN",
	      "name" => "Vietnam",
	      "phoneCode" => 84
	    ),
	    239 => array(
	      "id" => 239,
	      "sortname" => "VG",
	      "name" => "Virgin Islands (British)",
	      "phoneCode" => 1284
	    ),
	    240 => array(
	      "id" => 240,
	      "sortname" => "VI",
	      "name" => "Virgin Islands (US)",
	      "phoneCode" => 1340
	    ),
	    241 => array(
	      "id" => 241,
	      "sortname" => "WF",
	      "name" => "Wallis And Futuna Islands",
	      "phoneCode" => 681
	    ),
	    242 => array(
	      "id" => 242,
	      "sortname" => "EH",
	      "name" => "Western Sahara",
	      "phoneCode" => 212
	    ),
	    243 => array(
	      "id" => 243,
	      "sortname" => "YE",
	      "name" => "Yemen",
	      "phoneCode" => 967
	    ),
	    244 => array(
	      "id" => 244,
	      "sortname" => "YU",
	      "name" => "Yugoslavia",
	      "phoneCode" => 38
	    ),
	    245 => array(
	      "id" => 245,
	      "sortname" => "ZM",
	      "name" => "Zambia",
	      "phoneCode" => 260
	    ),
	    246 => array(
	      "id" => 246,
	      "sortname" => "ZW",
	      "name" => "Zimbabwe",
	      "phoneCode" => 26
	    )
	);

	if (!empty($code)) {
		$sel_country = array();
		foreach ($countries as $k => $value) {
			if (strtolower($value['sortname']) == strtolower($code)) {
				$sel_country = $value;
				break;
			}
		}
		return $sel_country;
	}
	return $countries;
}