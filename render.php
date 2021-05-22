<?php
date_default_timezone_set('Asia/Jakarta');

function day_to_hari($day)
{
    return strtr($day, [
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    ]);
}

$filter = (!empty($_GET['filter'])) ? $_GET['filter'] : 0;
$array_days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

$this_timestamp = strtotime("+{$filter} month");
$this_month = date('m', $this_timestamp);
$this_year = date('Y', $this_timestamp);

$dates = date('t');
$start_day = date('D', mktime(0, 0, 0, $this_month, 1, $this_year));
$position_start_day = array_search($start_day, $array_days);

$result = [];

for($j = ($position_start_day - 1); $j >= 0; $j--) {
    $timestamp_month_ago = strtotime('-1 month', mktime(0, 0, 0, $this_month, 1, $this_year));
    $year_ago = date('Y', $timestamp_month_ago);
    $month_ago = date('m', $timestamp_month_ago);

    $temp_date_month_ago = date('t', $timestamp_month_ago) - $j;
    $temp_date_month_ago = strtotime("{$year_ago}-{$month_ago}-{$temp_date_month_ago}");
                
    $date_month_ago = date('j', $temp_date_month_ago);
    $day_month_ago = date('D', $temp_date_month_ago);
                
    $result[$day_month_ago][] = $date_month_ago;
}

for($i=1; $i <= (35 - $position_start_day); $i++) {
    $temp_date = mktime(0, 0, 0, $this_month, $i, $this_year);
    $date = date('j', $temp_date);
    $day = date('D', $temp_date);
        
    $result[$day][] = $date;
}

$this_month_format = date('M', $this_timestamp);
$this_month_format = strtr($this_month_format, [
    'Jan' => 'Januari',
    'Feb' => 'Februari',
    'Mar' => 'Maret',
    'Apr' => 'April',
    'May' => 'Mei',
    'Jun' => 'Juni',
    'Jul' => 'Juli',
    'Aug' => 'Agustus',
    'Sep' => 'September',
    'Oct' => 'Oktober',
    'Nov' => 'November',
    'Dec' => 'Desember'
]);
?>  

    <h2 class="text-center year">
        <?= $this_year ?> (<?= $this_month_format ?>)
        <div class="divider"></div>
    </h2>

    <div class="mt-5">
        <table class="table text-center">
            <thead>
                <tr>
                    <? foreach($array_days as $key => $value): ?>
                        <th><?= day_to_hari($value) ?></th>
                    <? endforeach ?>
                </tr>
            </thead>
            <tbody>
                <? for($i=0; $i < 5; $i++): ?>
                    <tr>
                        <? foreach($array_days as $key => $value): ?>
                            <td <?= ($value == 'Sun') ? 'class="text-danger"' : '' ?>>
                                <?= $result[$value][$i] ?>
                            </td>
                        <? endforeach ?>
                    </tr>
                <? endfor ?>
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <div class="row">
            <div class="col-6">
                <button id="btn-prev-month" class="btn btn-outline-info rounded col-8">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>

            <div class="col-6 text-right">
                <button id="btn-next-month" class="btn btn-outline-success rounded col-8">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>