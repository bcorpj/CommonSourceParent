<?php

namespace CommonSource\Additional;

class Requires
{

    /**
     * if POST request return `required`, otherwise `nullable`
     * @param bool $type
     * @return string
     */
    public static function assign (bool $type): string
    {
        return $type ? 'required' : 'nullable';
    }

}
