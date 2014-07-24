<?php

namespace Netgusto\ParameterTouchBundle\Composer;

use Composer\Script\Event;

use Symfony\Component\Filesystem\Filesystem,
    Symfony\Component\Filesystem\Exception\IOException;

class ScriptHandler
{
    public static function touch(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        if (!isset($extras['touch-parameters'])) {
            throw new \InvalidArgumentException('The parameter toucher needs to be configured through the extra.touch-parameters setting.');
        }

        $configs = $extras['touch-parameters'];

        if (!is_array($configs)) {
            throw new \InvalidArgumentException('The extra.touch-parameters setting must be an array.');
        }

        $fs = new Filesystem();
        $fs->touch($configs);
    }
}
