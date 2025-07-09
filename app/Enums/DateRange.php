<?php
namespace App\Enums;

enum DateRange:string
{
    case ThisYear = 'this_year';
    case LastYear = 'last_year';
    case ThisMonth = 'this_month';
    case LastMonth = 'last_month';
    case ThisWeek = 'this_week';
    case LastWeek = 'last_week';
}
