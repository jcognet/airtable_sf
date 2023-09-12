<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\Service\Holiday\IsHolidayDeterminator;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class ConfigSelector
{
    private const DEFAULT_FILENAME = 'default';
    private const HOLIDAY_FILENAME = 'holiday';

    public function __construct(
        private readonly string $pathToConfigurationYaml,
        private readonly ConvertBlockTypeToManagerType $convertBlockTypeToManagerType,
        private readonly IsHolidayDeterminator $isHolidayDeterminator
    ) {}

    /**
     * @return ManagerType[]
     */
    public function getBlocks(Carbon $date): array
    {
        $fs = new Filesystem();
        $fileName = $this->getFilePath($date->format('l'));

        if ($this->isHolidayDeterminator->isHoliday($date)) {
            $fileName = $this->getFilePath(self::HOLIDAY_FILENAME);
        }

        if ($fs->exists($fileName)) {
            $blockTypeListString = Yaml::parseFile($fileName);
        } else {
            $blockTypeListString = Yaml::parseFile($this->getFilePath(self::DEFAULT_FILENAME));
        }

        $blockTypeList = [];
        foreach ($blockTypeListString['blocks'] as $blockTypeString) {
            $blockTypeList[] = BlockType::make($blockTypeString);
        }

        $blockManagerList = [];
        foreach ($blockTypeList as $blockType) {
            $blockManagerList[] = $this->convertBlockTypeToManagerType->convert($blockType);
        }

        return $blockManagerList;
    }

    public function getAllBlocks(): array
    {
        $list = [];

        foreach (ManagerType::getListType() as $type) {
            $list[] = new ManagerType($type);
        }

        return $list;
    }

    protected function getFilePath(string $name): string
    {
        return sprintf('%s%s.yaml', $this->pathToConfigurationYaml, strtolower($name));
    }
}
