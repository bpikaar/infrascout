<?php

namespace App\Enums;

enum MethodType: string
{
    case RadioDetection = 'radio_detection';
    case Gyroscope = 'gyroscope';
    case TestTrench = 'test_trench';
    case GroundRadar = 'ground_radar';
    case CableFailure = 'cable_failure';
    case GpsMeasurement = 'gps_measurement';
    case Lance = 'lance';

    // methode vaststelling - cable failure
    case AFrame = 'A_Frame';
    case TDR = 'tdr';
    case Meggeren = 'meggeren';

    // Radiodetectie
    case SignalSonde = 'signaal_sonde';
    case SignalGeleider = 'signaal_geleider';
}

