<?php

namespace App\Enum;

enum EventTypeEnum: string
{
    case PAGE_VIEW = 'page_view';
    case CTA_CLICK = 'cta_click';
    case FORM_SUBMIT = 'form_submit';
}
