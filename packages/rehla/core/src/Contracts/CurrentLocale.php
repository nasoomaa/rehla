<?php

namespace Rehla\Core\Contracts;

interface CurrentLocale
{
    /**
     * @return string
     */
    public function code(): string;

    /**
     * @return string 'ltr' or 'rtl'
     */
    public function direction(): string;
}
