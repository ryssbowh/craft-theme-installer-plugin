<?php 

namespace Ryssbowh\ThemeInstaller;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use React\Promise\PromiseInterface;

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
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->removeCacheFile();

        return parent::install($repo, $package);
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        $this->removeCacheFile();

        return parent::update($repo, $initial, $target);
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->removeCacheFile();
       
        return parent::uninstall($repo, $package);
    }

    protected function removeCacheFile()
    {
        $ds = DIRECTORY_SEPARATOR;
        $file = $this->vendorDir . $ds . 'ryssbowh'. $ds .'craft-themes' . $ds . 'themes.php';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}