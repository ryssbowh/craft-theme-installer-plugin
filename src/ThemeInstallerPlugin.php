<?php 

namespace Ryssbowh\ThemeInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class ThemeInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new ThemeInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}