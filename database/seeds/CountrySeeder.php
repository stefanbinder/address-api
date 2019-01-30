<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = $this->getCountries();

        foreach($countries as $country) {
            $country = Country::create([
                'name' => $country['name'],
                'code2' => $country['code2'],
                'code3' => $country['code3'],
            ]);
        }

    }


    /**
     * Run the database seeds.
     *
     * @return array
     */
    public function getCountries()
    {
        return [
            [
                "code2" => "AT",
                "code3" => "AUT",
                "name" => "Austria",
                "capital" => "Vienna",
                "region" => "Europe",
                "subregion" => "Western Europe",
                "states" => [
                    [
                      "code" => "B",
                    "name" => "Burgenland",
                    "subdivision" => null
                    ],
                    [
                      "code" => "K",
                    "name" => "Kärnten",
                    "subdivision" => null
                    ],
                    [
                      "code" => "NÖ",
                    "name" => "Niederösterreich",
                    "subdivision" => null
                    ],
                    [
                      "code" => "OÖ",
                    "name" => "Oberösterreich",
                    "subdivision" => null
                    ],
                    [
                      "code" => "S",
                    "name" => "Salzburg",
                    "subdivision" => null
                    ],
                    [
                      "code" => "ST",
                    "name" => "Steiermark",
                    "subdivision" => null
                    ],
                    [
                      "code" => "T",
                    "name" => "Tirol",
                    "subdivision" => null
                    ],
                    [
                      "code" => "V",
                    "name" => "Vorarlberg",
                    "subdivision" => null
                    ],
                    [
                      "code" => "W",
                    "name" => "Wien",
                    "subdivision" => null
                    ]
                ]
            ],
            [
                "code2" => "US",
                "code3" => "USA",
                "name" => "United States",
                "capital" => "Washington, D.C.",
                "region" => "Americas",
                "subregion" => "Northern America",
                "states" => [
                    [
                      "code" => "DC",
                      "name" => "District of Columbia",
                      "subdivision" => "district"
                    ],
                    [
                      "code" => "AS",
                      "name" => "American Samoa",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "GU",
                      "name" => "Guam",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "MP",
                      "name" => "Northern Mariana Islands",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "PR",
                      "name" => "Puerto Rico",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "UM",
                      "name" => "United States Minor Outlying Islands",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "VI",
                      "name" => "Virgin Islands, U.S.",
                      "subdivision" => "outlying territory"
                    ],
                    [
                      "code" => "AL",
                      "name" => "Alabama",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "AK",
                      "name" => "Alaska",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "AZ",
                      "name" => "Arizona",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "AR",
                      "name" => "Arkansas",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "CA",
                      "name" => "California",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "CO",
                      "name" => "Colorado",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "CT",
                      "name" => "Connecticut",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "DE",
                      "name" => "Delaware",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "FL",
                      "name" => "Florida",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "GA",
                      "name" => "Georgia",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "HI",
                      "name" => "Hawaii",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "ID",
                      "name" => "Idaho",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "IL",
                      "name" => "Illinois",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "IN",
                      "name" => "Indiana",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "IA",
                      "name" => "Iowa",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "KS",
                      "name" => "Kansas",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "KY",
                      "name" => "Kentucky",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "LA",
                      "name" => "Louisiana",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "ME",
                      "name" => "Maine",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MD",
                      "name" => "Maryland",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MA",
                      "name" => "Massachusetts",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MI",
                      "name" => "Michigan",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MN",
                      "name" => "Minnesota",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MS",
                      "name" => "Mississippi",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MO",
                      "name" => "Missouri",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "MT",
                      "name" => "Montana",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NE",
                      "name" => "Nebraska",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NV",
                      "name" => "Nevada",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NH",
                      "name" => "New Hampshire",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NJ",
                      "name" => "New Jersey",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NM",
                      "name" => "New Mexico",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NY",
                      "name" => "New York",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "NC",
                      "name" => "North Carolina",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "ND",
                      "name" => "North Dakota",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "OH",
                      "name" => "Ohio",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "OK",
                      "name" => "Oklahoma",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "OR",
                      "name" => "Oregon",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "PA",
                      "name" => "Pennsylvania",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "RI",
                      "name" => "Rhode Island",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "SC",
                      "name" => "South Carolina",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "SD",
                      "name" => "South Dakota",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "TN",
                      "name" => "Tennessee",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "TX",
                      "name" => "Texas",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "UT",
                      "name" => "Utah",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "VT",
                      "name" => "Vermont",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "VA",
                      "name" => "Virginia",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "WA",
                      "name" => "Washington",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "WV",
                      "name" => "West Virginia",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "WI",
                      "name" => "Wisconsin",
                      "subdivision" => "state"
                    ],
                    [
                      "code" => "WY",
                      "name" => "Wyoming",
                      "subdivision" => "state"
                    ]
                ]
            ],
            [
                "code2" => "DE",
                "code3" => "DEU",
                "name" => "Deutschland",
            ],
            [
                "code2" => "SW",
                "code3" => "SWZ",
                "name" => "Schweiz",
            ],
            [
                "code2" => "ES",
                "code3" => "ESP",
                "name" => "Spain",
            ],
            [
                "code2" => "PT",
                "code3" => "POT",
                "name" => "Portugal",
            ],
            [
                "code2" => "FR",
                "code3" => "FRA",
                "name" => "France",
            ],
            [
                "code2" => "EN",
                "code3" => "ENG",
                "name" => "England",
            ],
            [
                "code2" => "IR",
                "code3" => "IRL",
                "name" => "Irland",
            ],
            [
                "code2" => "PL",
                "code3" => "POL",
                "name" => "Poland",
            ],
            [
                "code2" => "CZ",
                "code3" => "CZA",
                "name" => "Chech Republic",
            ],
            [
                "code2" => "HU",
                "code3" => "HUR",
                "name" => "Hungary",
            ],
            [
                "code2" => "RU",
                "code3" => "RUM",
                "name" => "Rumania",
            ],
            [
                "code2" => "RU",
                "code3" => "RUS",
                "name" => "Russia",
            ],
        ];
    }
}
