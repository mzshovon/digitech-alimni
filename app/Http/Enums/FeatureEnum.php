<?php

declare(strict_types=1);

namespace App\Http\Enums;

enum FeatureEnum: string {
    // case Login = 'login';
    // case Register = 'register';
    case Home = 'home';
    case Dashboard = 'dashboard';
    case ContactUs = 'contact-us';
    case NewsLetter = 'newsletter';
    case Members = 'members';
    case Payment = 'payment';
    case Election = 'election';
}
