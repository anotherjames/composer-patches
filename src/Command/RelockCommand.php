<?php

declare(strict_types=1);

namespace cweagans\Composer\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RelockCommand extends PatchesCommandBase
{
    protected function configure(): void
    {
        $this->setName('patches-relock');
        $this->setDescription('Find all patches defined in the project and re-write patches.lock.');
        $this->setAliases(['prl']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $plugin = $this->getPatchesPluginInstance();
        if (is_null($plugin)) {
            return 1;
        }

        if (file_exists($plugin->getLockFile()->getPath())) {
            unlink($plugin->getLockFile()->getPath());
        }
        $plugin->createNewPatchesLock();
        $output->write('  - <info>patches.lock</info> has been recreated successfully.', true);
        return 0;
    }
}
