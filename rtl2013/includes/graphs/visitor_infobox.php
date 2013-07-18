<?php
/*
  $Page ID: visitor_infobox.php,v2.2c, Dated: 01 May 2005 [Visitors File] Ian-San $
  http://www.gowebtools.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

   mod eSklep-Os http://www.esklep-os.com
*/

  include_once(DIR_WS_CLASSES . 'phplot.php');
  
  $stats = array();
  $terms = array(); 
  $terms_grouped = array();
  $stats_grouped = array();
  $stats_grouped_2 = array();
  $stats_grouped_3 = array();
 
// Custom Sort Functions
  function compare1($x, $y) {
   if ($x[0] == $y[0]) {
        return 0;
    } else {
    if ($x[0] <  $y[0]) {
        return -1;
      } else {
        return 1;
      }
     }
   }

   function compare2($x, $y) {
   if ($x[1] == $y[1]) {
        return 0;
     } else {
     if ($x[1] <  $y[1]) {
        return -1;
      } else {
        return 1;
      }
     }
   }
   
   function compare3($x, $y) {
   if ($x[1] == $y[1]) {
        return 0;
     } else {
     if ($x[1] >  $y[1]) {
        return -1;
      } else {
        return 1;
      }
     }
   }
 
  switch ($report) {
    case "1": // Visits By Hours Today
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, count(counter) as value from " . TABLE_VISITORS . " where to_days(now()) - to_days(date) < 1 $robot group by HOUR(date)");
    break;
    case "3": // Visits By Months this Year 
     $visitor_stats_query = tep_db_query("select MONTHNAME(date) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by MONTH(date)");
    break;
    case "4": // Visits All Time Sum by Year
      $visitor_stats_query = tep_db_query("select YEAR(date) as name, count(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by YEAR(date)");
    break;
    case "5": // Visits All Time Sum by Hours
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, count(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by HOUR(date)");
    break;
    case "6": // Visits By Day of Month this Year
     $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, count(counter) as value from " . TABLE_VISITORS . "  where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
    break;
    case "7": // Hits All Time Average per IP by Days
     $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, avg(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by DAYOFMONTH(date)");
    break;
    case "8": // Hits All Time Total by Browser Language
     $visitor_stats_query = tep_db_query("select browser_language as name, sum(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by browser_language");
    break;
    case "9": // Hits All Time by Time Online
     $visitor_stats_query = tep_db_query("select ROUND(((UNIX_TIMESTAMP(online) - UNIX_TIMESTAMP(date))/60),0) as name, sum(counter) as value from " . TABLE_VISITORS . " " . str_replace('AND', 'WHERE', $robot) . " group by name");
    break;
    case "10": // Search Engine Keyword Summary for past 90 Days
     $visitor_stats_query = tep_db_query("select referer as name, count(counter) as value from " . TABLE_VISITORS . " where TO_DAYS(now()) - TO_DAYS(date) < " . KEYWORD_DURATION . " group by referer");
    break;
    case "11": //  Hits All Time Sum by Country
     $visitor_stats_query = tep_db_query("select browser_ip as name, sum(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by browser_ip");
    break;
    case "12": // Visits All Time Total by Browser Language
     $visitor_stats_query = tep_db_query("select browser_language as name, count(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by browser_language");
    break;
    case "13": //  Visits All Time Sum by Country
     $visitor_stats_query = tep_db_query("select browser_ip as name, count(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by browser_ip");
    break;
    case "20": // Visits Yesterday by Hours
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, count(counter) as value from " . TABLE_VISITORS . " where to_days(now())-1 = to_days(date) $robot group by HOUR(date)");
    break;
    case "21": // Visits Same Day Last Week
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, count(counter) as value from " . TABLE_VISITORS . " where to_days(now())-7 = to_days(date) $robot group by HOUR(date)");
    break;
    case "22": // Visits By days last 2 Months
	 if (date('n') == '1') {
       $visitor_stats_query = tep_db_query("select date as name, count(counter) as value from " . TABLE_VISITORS . " where ((MONTH(date) = '1' and YEAR(now()) - YEAR(date) < 1) or ((MONTH(date) = '12') and (YEAR(now())-1 = YEAR(date)))) $robot group by MONTH(date) DESC, DAYOFYEAR(date)");
     } else {
       $visitor_stats_query = tep_db_query("select date as name, count(counter) as value from " . TABLE_VISITORS . " where MONTH(now()) - MONTH(date) < 2 and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFYEAR(date)");
	 }
	break;
    case "23": // Hits Recent 24 Hours
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where to_days(now()) - to_days(date) < 1 $robot group by HOUR(date)");
    break;
    case "24": // Hits By Days this Month
     $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where MONTH(now()) - MONTH(date) < 1 and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
    break;
    case "25": // Hits By Months this Year
     $visitor_stats_query = tep_db_query("select MONTHNAME(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by MONTH(date)");
    break;
    case "26": // Hits All Time Sum by Year
      $visitor_stats_query = tep_db_query("select YEAR(date) as name, sum(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by YEAR(date)");
    break;
    case "27": // Hits All Time Sum by Hour
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, sum(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by HOUR(date)");
    break;
    case "28": // Hits By Day of Month this Year
     $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, sum(counter) as value from " . TABLE_VISITORS . "  where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
    break;
    case "29": // Hits Yesterday by Hours
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where to_days(now())-1 = to_days(date) $robot group by HOUR(date)");
    break;
    case "30": // Hits Same Day Last Week
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where to_days(now())-7 = to_days(date) $robot group by HOUR(date)");
    break;
    case "31": // Hits By Days last 2 Months
     if (date('n') == '1') {
       $visitor_stats_query = tep_db_query("select date as name, sum(counter) as value from " . TABLE_VISITORS . " where ((MONTH(date) = '1' and YEAR(now()) - YEAR(date) < 1) or ((MONTH(date) = '12') and (YEAR(now())-1 = YEAR(date)))) $robot group by MONTH(date) DESC, DAYOFYEAR(date)");
     } else {
       $visitor_stats_query = tep_db_query("select date as name, sum(counter) as value from " . TABLE_VISITORS . " where MONTH(now()) - MONTH(date) < 2 and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFYEAR(date)");
	 }
    break;
    case "32": // Visits Trend This Year
     $visitor_stats_query = tep_db_query("select DAYOFYEAR(date) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFYEAR(date)");
    break;
    case "33": // Hits Trend This Year
     $visitor_stats_query = tep_db_query("select DAYOFYEAR(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFYEAR(date)");
    break;
    case "34": // Visits All Time by Time Online
     $visitor_stats_query = tep_db_query("select ROUND(((UNIX_TIMESTAMP(online) - UNIX_TIMESTAMP(date))/60),0) as name, count(counter) as value from " . TABLE_VISITORS . "  " . str_replace('AND', 'WHERE', $robot) . " group by name");
    break;
    case "35": // Visits by Day of the Week This Year
     $visitor_stats_query = tep_db_query("select DAYNAME(date) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFWEEK(date)");
    break;
    case "36": // Hits by Day of the Week This Year
     $visitor_stats_query = tep_db_query("select DAYNAME(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFWEEK(date)");
    break;
    case "37": // Visits Sum by Quarter this Year
     $visitor_stats_query = tep_db_query("select QUARTER(date) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by QUARTER(date)");
    break;
    case "38": // Hits Sum by Quarter this Year
     $visitor_stats_query = tep_db_query("select QUARTER(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by QUARTER(date)");
    break;
    case "39": // Visits Sum by Week Number this Year
     $visitor_stats_query = tep_db_query("select WEEK(date,2) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by WEEK(date,2)");
    break;
    case "40": // Hits Sum by Week Number this Year
     $visitor_stats_query = tep_db_query("select WEEK(date,2) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now()) - YEAR(date) < 1 $robot group by WEEK(date,2)");
    break;
    case "41": // Hits Average All Time by Hours
     $visitor_stats_query = tep_db_query("select HOUR(date) as name, avg(counter) as value from " . TABLE_VISITORS . " " . str_replace('AND', 'WHERE', $robot) . " group by HOUR(date)");
    break;
    case "42": // Visits By Months last Year 
     $visitor_stats_query = tep_db_query("select MONTHNAME(date) as name, count(counter) as value from " . TABLE_VISITORS . " where YEAR(now())-1 = YEAR(date) $robot group by MONTH(date)");
    break;
    case "43": // Visits By days last Month
	 if (date('n') == '1') {
       $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, count(counter) as value from " . TABLE_VISITORS . " where MONTH(date) = '12' and YEAR(now())-1 = YEAR(date) $robot group by DAYOFMONTH(date)");
     } else {
       $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, count(counter) as value from " . TABLE_VISITORS . " where MONTH(now())-1 = MONTH(date) and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
	 }
	break;
    case "44": // Hits By days last Month
	 if (date('n') == '1') {
       $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where MONTH(date) = '12' and YEAR(now())-1 = YEAR(date) $robot group by DAYOFMONTH(date)");
     } else {
       $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where MONTH(now())-1 = MONTH(date) and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
	 }
	break;
    case "45": // Hits By Months last Year
     $visitor_stats_query = tep_db_query("select MONTHNAME(date) as name, sum(counter) as value from " . TABLE_VISITORS . " where YEAR(now())-1 = YEAR(date) $robot group by MONTH(date)");
    break;
    default: // Report 2: Visits By Days this Month
     $visitor_stats_query = tep_db_query("select DAYOFMONTH(date) as name, count(counter) as value from " . TABLE_VISITORS . " where MONTH(now()) - MONTH(date) < 1 and YEAR(now()) - YEAR(date) < 1 $robot group by DAYOFMONTH(date)");
   }

while ($visitor_stats = tep_db_fetch_array($visitor_stats_query)) {

// Find the Country Name    
if ( ($report == '8') || ($report == '12') ){ 

// Exclude Robots for now    
if ( substr($visitor_stats['name'], 0, 1) != '[' ) {
    $stats[] = array(visitor_get_country_language($visitor_stats['name']), $visitor_stats['value']);
} else {

// Add back the Robots    
    $stats[] = array('Network', $visitor_stats['value']);
}
  } else {

// Build the Data Array for the other reports
   if ( ($report == '22') || ($report == '31') ) {
      $stats[] = array(tep_date_short($visitor_stats['name']), round($visitor_stats['value'],1));
   } else {
      $stats[] = array($visitor_stats['name'], round($visitor_stats['value'],1));
   }
}
  
// Build the Data Array for the Keyword Report
  if ($report == '10'){
    $ref = strtolower($visitor_stats['name']);
    if(stristr($ref, 'search') && stristr($ref, '?') && !stristr($ref, 'ba=')) { 
	    $ref = substr($ref, strpos($ref, '?')+1);
		$ref = str_replace('sp=', '', $ref);
        $x = explode('&', $ref); 
        foreach ($x as $var) { 
            if(stristr($var, 'q=') || stristr($var, 'p=')) { 
                $ref = $var; 
            }
        }
        $ref = urldecode ($ref);
        $ref = str_replace('utf-8', '', $ref);
        $ref = str_replace('+', '', $ref);
        $ref = str_replace('"', '', $ref);
        $ref = str_replace(' ', 'qq', $ref);
        if(stristr($ref, '=')) {$ref = substr($ref, strpos($ref, '=')+1);}
        if(stristr($ref, '=')) {$ref = substr($ref, strpos($ref, '=')+1);}
        if(stristr($ref, '=')) {$ref = substr($ref, strpos($ref, '=')+1);}
        if(stristr($ref, '=')) {$ref = substr($ref, strpos($ref, '=')+1);}
        if(stristr($ref, '=')) {$ref = substr($ref, strpos($ref, '=')+1);}
// Änderung Ernst 27.9.2004 wegen anzeige von Zahlen im Search String
//                $ref = ereg_replace("[^[:alpha:]]", "", $ref);
        $ref = str_replace('qq', ' ', $ref);
        $ref = str_replace('fptop', '', $ref);
        $ref = str_replace('flxwrt', '', $ref);
        $ref = str_replace('xwrt', '', $ref);
        $ref = str_replace('flxwr', '', $ref);
        $ref = str_replace('flx', '', $ref);
		if ($ref == 'fl') {$ref = '';} 
        if(strlen($ref) >1) {
		   $count = 1;
           $terms[] = array($ref, $count);
		}
     } 
  }
}

// Turn ip Addresses into Countries for Country Report
if ( ($report == '11') || ($report == '13') ){

require(DIR_WS_INCLUDES . 'geoip.inc');
$gi = geoip_open(DIR_WS_INCLUDES . 'GeoIP.dat',GEOIP_STANDARD);

for ($row = 0; $row < sizeof($stats); $row++) {
   $country_name = geoip_country_name_by_addr($gi, $stats[$row][0]);
   $country_count = $stats[$row][1];
   $stats_grouped_4[] = array($country_name, $country_count);
}
$stats = $stats_grouped_4;
}

// Sort and combine the Country Names as we may have some duplicates
if ( ($report == '8') || ($report == '11') || ($report == '12') || ($report == '13') ){

@usort($stats, compare1);

for ($row = 0; $row < sizeof($stats); $row++) {
   $country_name = $stats[$row][0];
   $country_count = $stats[$row][1];
   while ($stats[$row+1][0] == $stats[$row][0]) {
   $row++;
   $country_count = $stats[$row][1] + $country_count;
   }
   $stats_grouped[] = array($country_name, $country_count);
}

$stats = $stats_grouped;
@usort($stats, compare2);

// How many Countries shall I show?
if (NO_COUNTRIES_FOR_CHART) {
   $no_countries_to_show = MIN(NO_COUNTRIES_FOR_CHART + 1, sizeof($stats));
} else {
   $no_countries_to_show = '10'; // Default = 9 Countries + Robots + Others = 11 data points = 0 to 10
}

// Add up Others to Tag on the end of the Array
for ($row = 0; $row < sizeof($stats) - $no_countries_to_show; $row++) {
   $country_count = $stats[$row][1];
   $others_count = $others_count + $country_count;
}

$stats_grouped_2[] = array("Others", $others_count);

// Cut the Countries we want to show from the array
for ($row = sizeof($stats) - $no_countries_to_show; $row < sizeof($stats); $row++) {
   $country_name = $stats[$row][0];
   $country_count = $stats[$row][1];
   $stats_grouped_2[] = array($country_name, $country_count);
}
$stats = $stats_grouped_2;
}

// Sort the Data Array for the Time Online Report
if ( ($report == '9') || ($report == '34') ){

@usort($stats, compare2);

// How many ONLINE shall I show?
if (NO_ONLINE_FOR_CHART) {
   $no_online_to_show = NO_ONLINE_FOR_CHART + 1;
} else {
   $no_online_to_show = '9'; // Default = 9 Entries + Others = 10 data points = 0 to 10
}

// Add up Others to Tag on the end of the Array
for ($row = 0; $row < sizeof($stats) - $no_online_to_show; $row++) {
   $online_count = $stats[$row][1];
   $others_online_count = $others_online_count + $online_count;
}

$stats_grouped_3[] = array("Others", $others_online_count);

// Cut the Entries we want to show from the array
for ($row = sizeof($stats) - $no_online_to_show; $row < sizeof($stats); $row++) {
   $online_name = $stats[$row][0];
   $online_count = $stats[$row][1];
   $stats_grouped_3[] = array($online_name, $online_count);
}
$stats = $stats_grouped_3;
}

// Create Report Array for Keywords
if ($report == '10'){

@usort($terms, compare1);
for ($row = 0; $row < sizeof($terms); $row++) {
   $search_name = $terms[$row][0];
   $search_count = '1';
   while ($terms[$row+1][0] == $terms[$row][0]) {
   $row++;
   $search_count = $terms[$row][1] + $search_count;
   }
   $terms_grouped[] = array($search_name, $search_count);
}

@usort($terms_grouped, compare3);

}

// Something for an empty array
  if (sizeof($stats) < 1) $stats = array(array(date('j'), 0));

// Provide the Chart Settings
  $target = DIR_WS_IMAGES . 'graphs/visitor_infobox-' . $report . '.png';
  
  switch ($report) {
    case '1': // Visits By Hours Today
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '2': // Visits By Days this Month
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '3': // Visits By Months this Year
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '4': // Visits All Time Sum by Year
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '5': // Visits All Time Sum by Hours
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('linepoints');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '6': // Visits All Time Sum by Day of Month
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '7': // Hits All Time Average per IP by Days
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('orange'),array('orange'));
	  break;
    case '8': // Hits All Time Total by Browser Language
      $graph = new PHPlot(480, 490, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,120);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case '9': // Hits All Time by Time Online
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case "10": // Search Engine Keyword Summary for past 90 Days - Not used, just a backup
	  break;
    case '11': // Hits All Time Sum by Country
      $graph = new PHPlot(480, 490, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,120);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case '12': // Visits All Time Total by Browser Language
      $graph = new PHPlot(480, 490, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,120);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case '13': // Visits All Time Sum by Country
      $graph = new PHPlot(480, 490, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,120);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case '20': // Visits Yesterday by Hours
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '21': // Visits Same Day Last Week
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '22': // Visits By days last 2 Months
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '23': // Hits Recent 24 Hours
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '24': // Hits By Days this Month
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '25': // Hits By Months this Year
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '26': // Hits All Time Sum by Year
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '27': // Hits All Time Sum by Hour
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('linepoints');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '28': // Hits All Time Sum by Day of Month
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '29': // Hits Yesterday by Hours
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '30': // Hits Same Day Last Week
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '31': // Hits By Days last 2 Months
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '32': // Visits Trend This Year
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('linepoints');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '33': // Hits Trend This Year
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('linepoints');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '34': // Visits All Time by Time Online
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('green'),array('green'));
	  break;
    case '35': // Visits All Time Sum by Day of the Week
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '36': // Hits All Time Sum by Day of the Week
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '37': // Visits Sum by Quarter this Year
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '38': // Hits Sum by Quarter this Year
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '39': // Visits Sum by Week Number this Year
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '40': // Hits Sum by Week Number this Year
      $graph = new PHPlot(480, 420, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,50);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '41': // Hits Average All Time by Hours
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('0');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('red'),array('red'));
	  break;
    case '42': // Visits By Months this Year
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '43': // Visits By days last Month
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '44': // Hits By days last Month
      $graph = new PHPlot(480, 400, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
    case '45': // Hits By Months this Year
      $graph = new PHPlot(480, 450, $target);
      $graph->SetXDataLabelAngle('90');
      $graph->SetMarginsPixels(15,15,15,80);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
	  break;
	default:
      $graph = new PHPlot(480, 400, $target);
  $graph->SetXDataLabelAngle('0');
  $graph->SetMarginsPixels(15,15,15,30);
      $graph->SetPlotType('bars');
      $graph->SetDataColors(array('blue'),array('blue'));
  } 
  
  if ($report != '10') {
  $graph->SetFileFormat(png);
  $graph->SetIsInline(1);
  $graph->SetPrintImage(0);

  $graph->draw_vert_ticks = 0;
  $graph->SetSkipBottomTick(1);
  $graph->SetDrawXDataLabels(0);
  $graph->SetDrawYGrid(0);
  $graph->SetDrawDataLabels(1);
  $graph->SetLabelScalePosition(1);
  
  $graph->SetTitle(CHART_TITLE . ' ' . $title);
    $graph->SetYLabel("http://www.gowebtools.com");
  $graph->SetTitleFontSize('4');

  $graph->SetDataValues($stats);
  $graph->DrawGraph();

  $graph->PrintImage();
  chmod ("$target", 0776);
  }
?>
