<?php

namespace Flames\Transpiler\Scss;

enum DeprecationStatus
{
    case active;
    case user;
    case future;
    case obsolete;
}
