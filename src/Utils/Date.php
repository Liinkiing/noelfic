<?php

namespace App\Utils;

class Date
{
    public static function getOrderedChartData(array $result, string $countAlias): array
    {

        if (empty($result)) {
            return [
                'labels' => [],
                'series' => [[0]]
            ];
        }

        $orderedEntities = [];
        foreach ($result as $key => $entityCount) {
            $orderedEntities[$entityCount['dayOfWeek']] = $entityCount;
        }
        $finalArray = [];
        $daysKeys = range(0, 6, 1);
        foreach ($orderedEntities as $key => $entity) {
            $finalArray['labels'] = array_map(function($key) {
                return (new \DateTime("monday this week +$key day"))
                    ->format('D');
            }, $daysKeys);
            $finalArray['series'][] = array_map(function($key) use ($orderedEntities, $countAlias) {
                return isset($orderedEntities[$key]) ? (int) $orderedEntities[$key][$countAlias] : 0;
            }, $daysKeys);
        }
        return $finalArray;
    }
}
