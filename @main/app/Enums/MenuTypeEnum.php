<?php

namespace App\Enums;

enum MenuTypeEnum: string
{
    case HEADER_STYLE_1 = 'Header_Style_1';
    case HEADER_HOME_1_RIGHT_SIDE = 'Header_Style_1_Right_Side';
    case FOOTER_STYLE_1_C1 = 'Footer_Style_1_C1';
    case FOOTER_STYLE_1_C2 = 'Footer_Style_1_C2';
    case FOOTER_STYLE_1_C3 = 'Footer_Style_1_C3';
    case FOOTER_STYLE_1_Copyright = 'Footer_Style_1_Copyright';
    case HEADER_STYLE_2 = 'Header_Style_2';
    case HEADER_STYLE_2_RIGHT_SIDE = 'Header_Style_2_Right_Side';
}