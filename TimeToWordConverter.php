<?php


interface TimeToWordConvertingInterface
{
    public function convert(int $hours, int $minutes): string;
}

class TimeToWordConverter implements TimeToWordConvertingInterface {
    public function convert(int $hours, int $minutes): string
    {
        $minutesStr = ($minutes < 10) ? "0" .  (string)($minutes) : $minutes;

        $time = $hours . ":" . $minutesStr;
        $result = $time . ' - ';

        if ($minutes == 0) {
            $resHours = $hours;
            $end = 'часов';

            $result .= $resHours;
            $result .= $end;
        } else {
            if ($minutes > 30) {
                $link = 'до';
                $resMinutes = 60 - $minutes;
                $resHours = $hours + 1;
                $strMinutes = $this->declinationByNumbers($resMinutes);

                $result .= $resMinutes . ' ';
                $result .= $strMinutes . ' ';
                $result .= $link . ' ';
                $result .= $resHours . ' ';

            } else if ($minutes < 30) {
                $link = 'после';
                $resMinutes = $minutes;
                $resHours = $hours;
                $strMinutes = $this->declinationByNumbers($resMinutes);

                $result .= $resMinutes . ' ';
                $result .= $strMinutes . ' ';
                $result .= $link . ' ';
                $result .= $resHours . ' ';
            } else {
                $link = 'Половина';
                $resHours = $hours;

                $result .= $link . ' ';
                $result .= $resHours . ' ';
            }
        }

        return trim($result) . '.';
    }

    private function declinationByNumbers(int $n, array $titles = array('минута', 'минуты', 'минут')) : string
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }
}