<?php

if (!function_exists('DDtoDMS')) {
    function DDtoDMS($dd)
    {
        $d = intval(abs($dd));
        $m = intval(($dd - $d) * 60);
        $s = intval(($dd - $d - $m / 60) * 3600);
        return ["deg" => intval($d), "min" => intval($m), "sec" => intval($s)];
    }
}


if (!function_exists('DMStoDD')) {
    function DMStoDD($deg, $min, $sec, $cardinaux, $coordonnee)
    {
        $dd = $deg + ($min / 60) + ($sec / 3600);
        $_dd = -$dd;
        if ($coordonnee == 'lat') {
            if ($cardinaux == 'N') {
                return $dd;
            }
            if ($cardinaux == 'S') {
                return $_dd;
            }
        }
        if ($coordonnee == 'long') {
            if ($cardinaux == 'E') {
                return $dd;
            }
            if ($cardinaux == 'O') {
                return $_dd;
            }
        }
    }
}

if (!function_exists('calculatePeriods')) {
    function calculatePeriods($data)
    {
        $loopArr = array_merge(range(1, 12), range(1, 12), range(1, 12),
          range(1, 12), range(1, 12));

        $seekArr = [
          [
            'planets' => [
              'Ch', // Луна
              'Sy', // Солнце
              'Bu', // Меркурий
              'Ve', //Венера
              'Sk', //Венера
            ],
            'calc'    => [
              7,
            ],
          ],
          [
            'planets' => [
              'Gu', // Юпитер
            ],
            'calc'    => [
              5, 7, 9,
            ],
          ],
          [
            'planets' => [
              'Ra', // Раху
            ],
            'calc'    => [
              5, 7, 9,
            ],
          ],
          [
            'planets' => [
              'Sa', // Сатурн
            ],
            'calc'    => [
              3, 7, 10,
            ],
          ],
          [
            'planets' => [
              'Ma', // Марс
            ],
            'calc'    => [
              4, 7, 8,
            ],
          ],
        ];

        foreach ($data as $key => &$datum) {
            if (isset($datum['rashi'])) {
                foreach ($seekArr as $item) {
                    if (in_array($key, $item['planets'])) {
                        foreach ($item['calc'] as $calc) {
                            $datum['aspected'][] = $loopArr[$datum['rashi']
                            + $calc - 2];
                        }
                        continue 2;
                    }
                }
            }
        }

        return $data;
    }
}



