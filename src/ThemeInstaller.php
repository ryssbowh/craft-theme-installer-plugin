<?php 

namespace Ryssbowh\ThemeInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class ThemeInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $extra = $package->getExtra();
        if (isset($extra['name'])) {
            $name = $extra['name'];
        } else {
            preg_match('/^([A-Za-z0-9_\-]+)\/([A-Za-z0-9_\-]+)$/', $package->getPrettyName(), $matches);
            if (sizeof($matches) != 3) {
                throw new \InvalidArgumentException(
                    'Couldn\t find the theme name, craft themes must have their names in the \'name\' extra, or have the following name : namespace/{name}'
                );
            }
            $name = $matches[2];
        }

        return 'themes/'.$name;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'craft-theme' === $packageType;
    }
}