<?php 

namespace Ryssbowh\ThemeInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class ThemeInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $extra = $package->getExtra();
        if (isset($extra['handle'])) {
            $handle = $extra['handle'];
        } else {
            preg_match('/^([A-Za-z0-9_\-]+)\/([A-Za-z0-9_\-]+)$/', $package->getPrettyName(), $matches);
            if (sizeof($matches) != 3) {
                throw new \InvalidArgumentException(
                    'Couldn\t find the theme\'s handle, craft themes must have their names in the \'handle\' extra, or have the following name : namespace/{handle}'
                );
            }
            $handle = $matches[2];
        }

        return 'themes/'.$handle;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'craft-theme' === $packageType;
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
        if ($package->getType() == 'craft-theme') {
            $this->removeCacheFile();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
        if ($package->getType() == 'craft-theme') {
            $this->removeCacheFile();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);
        if ($package->getType() == 'craft-theme') {
            $this->removeCacheFile();
        }
    }

    protected function removeCacheFile()
    {
        $ds = DIRECTORY_SEPARATOR;
        $file = dirname($this->vendorDir) . $ds . 'storage'. $ds .'runtime' . $ds .'themes' . $ds .'themes';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}