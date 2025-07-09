<?php

namespace App\Enums;

enum UserRoles:string
{
    case SuperAdmin = 'super-admin';
    case OrgAdmin = 'org-admin';
    case LegalAdmin = 'legal-admin';
    case Lawyer = 'lawyer';
    case NfpAdmin = 'nfp-admin';
    case ClientAdmin = 'client-admin';
    case Individual = 'individual';
}
