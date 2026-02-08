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
}

