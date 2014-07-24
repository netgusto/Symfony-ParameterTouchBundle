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

        foreach($configs as $config) {
            if(is_string($config)) {
                $fs->touch($config);
                continue;
            }

            if(is_array($config)) {
                $src = $config['src'];
                $dest = $config['dest'];

                if(!$fs->exists($src)) {
                    throw new IOException("ParameterTouchBundle: source file does not exist: '" . $src . "'");
                }

                if(!$fs->exists($dest)) {
                    # copy only if dest file does not exist
                    $fs->copy($src, $dest);
                }
            }
        }
    }
}
