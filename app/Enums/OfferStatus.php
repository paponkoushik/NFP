<?php

namespace App\Enums;

enum OfferStatus:string
{
    case Pending = 'pending';
    case Accept = 'accept';
    case Reject = 'reject';
    case Offered = 'offered';
    case Cancel = 'cancel';
}
