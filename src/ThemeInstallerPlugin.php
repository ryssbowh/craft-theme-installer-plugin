<?php 

namespace Ryssbowh\ThemeInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class ThemeInstallerPlugin implements PluginInterface
{
     /**
     * @var ThemeInstaller
     */
    private $installer;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->installer = new ThemeInstaller($io, $composer, 'craft-theme');
        $composer->getInstallationManager()->addInstaller($this->installer);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {}
}