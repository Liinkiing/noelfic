<?php

namespace App\Utils;

class Date
{
    public static function getOrderedChartData(array $result, string $countAlias, string $locale): array
    {
        if (empty($result)) {
            return ['labels' => [], 'series' => [[0]]];
        }

        $orderedEntities = [];
        foreach ($result as $key => $entityCount) {
            $orderedEntities[$entityCount['dayOfWeek']] = $entityCount;
        }
        $finalArray = [];
        $daysKeys = range(0, 6, 1);
        foreach ($orderedEntities as $key => $entity) {
            $finalArray['labels'] = array_map(function($key) use ($locale) {
                return substr(
                    self::getLocalizedDate(new \DateTime("monday this week +$key day"), $locale, 'EEEE'),
                    0,
                    3
                );
            }, $daysKeys);
            $finalArray['series'][] = array_map(function($key) use ($orderedEntities, $countAlias) {
                return isset($orderedEntities[$key]) ? (int) $orderedEntities[$key][$countAlias] : 0;
            }, $daysKeys);
        }
        return $finalArray;
    }

    /**
     * @param \DateTime   $date
     * @param string|null $locale
     * @param string|null $format
     * @param int         $dateFormat
     * @param int         $timeFormat
     * @param int|null    $calendar
     *
     * @return string
     */
    public static function getLocalizedDate(\DateTime $date, ?string $locale = null, ?string $format = null, int $dateFormat = \IntlDateFormatter::MEDIUM, int $timeFormat = \IntlDateFormatter::MEDIUM, int $calendar = \IntlDateFormatter::GREGORIAN): string
    {
        $formatter = \IntlDateFormatter::create($locale, $dateFormat, $timeFormat, $date->getTimezone()->getName(), $calendar, $format);
        return $formatter->format($date->getTimestamp());
    }
}
