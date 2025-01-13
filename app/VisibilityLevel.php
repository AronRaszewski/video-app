<?php

namespace App;

enum VisibilityLevel: string
{
    //
    case Public = 'public';
    case Restricted = 'restricted';
    case Private = 'private';
}
