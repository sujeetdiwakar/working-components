<?php

/* draws a calendar */
function draw_calendar( $month, $year ) {

    $monthName = date("F", mktime(0, 0, 0, $month, 10));
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
	$calendar .= ' <caption>'.$monthName.'</caption>';
	$headings = [ 'S', 'M', 'T', 'W', 'T', 'F', 'S' ];
	$calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode( '</td><td class="calendar-day-head">', $headings ) . '</td></tr>';

	$running_day       = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_month     = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_this_week = 1;
	$day_counter       = 0;
	$dates_array       = [];

	$calendar .= '<tr class="calendar-row">';

	for ( $x = 0; $x < $running_day; $x ++ ):
		$calendar .= '<td class="calendar-day-np"> </td>';
		$days_in_this_week ++;
	endfor;

	for ( $list_day = 1; $list_day <= $days_in_month; $list_day ++ ):
		$calendar .= '<td class="calendar-day">';
        global $wp_query;
        $curr_auth = $wp_query->get_queried_object();
        $u_id    = $curr_auth->ID;
        $query = new WP_Query( [
            'post_type'      => 'report',
            'author__in'     => [ $u_id ],
            'posts_per_page' => 20,
            'date_query'     => [
                [
                    'year'  => $year,
                    'month' => $month,
                    'day'   => $list_day,
                ],
            ],
        ] );

        if ( $query->have_posts() ):
		$calendar .= '<div class="day-number"><a href="?year=' . $year . '&month=' . $month . '&day=' . $list_day . '"> ' . $list_day . '</a></div>';
        else:
		$calendar .= '<div class="day-number">' . $list_day . '</div>';
        endif;

		$calendar .= str_repeat( '<p> </p>', 2 );

		$calendar .= '</td>';
		if ( $running_day == 6 ):
			$calendar .= '</tr>';
			if ( ( $day_counter + 1 ) != $days_in_month ):
				$calendar .= '<tr class="calendar-row">';
			endif;
			$running_day       = - 1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week ++;
		$running_day ++;
		$day_counter ++;
	endfor;

	if ( $days_in_this_week < 8 ):
		for ( $x = 1; $x <= ( 8 - $days_in_this_week ); $x ++ ):
			$calendar .= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	$calendar .= '</tr>';

	$calendar .= '</table>';

	return $calendar;
}