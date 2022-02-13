<?php
declare(strict_types=1);

namespace App\Service\NewsletterManager;

use App\Service\Converter\ConvertBlockTypeToManagerType;
use App\ValueObject\NewsletterBlockManager\BlockType;
use App\ValueObject\NewsletterBlockManager\ManagerType;
use Carbon\Carbon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class ConfigSelector
{
    private string $pathToConfigurationYaml;
    private ConvertBlockTypeToManagerType $convertBlockTypeToManagerType;

    public function __construct(string $pathToConfigurationYaml, ConvertBlockTypeToManagerType $convertBlockTypeToManagerType)
    {
        $this->pathToConfigurationYaml = $pathToConfigurationYaml;
        $this->convertBlockTypeToManagerType = $convertBlockTypeToManagerType;
    }

    /**
     * @return ManagerType[]
     */
    public function getBlocks(Carbon $date): array
    {
        $fs = new Filesystem();
        $weekDay = $this->getFilePath($date->format('l'));

        if ($fs->exists($weekDay)) {
            $blockTypeListString = Yaml::parseFile($weekDay);
        } else {
            $blockTypeListString = Yaml::parseFile($this->getFilePath('default'));
        }

        $blockTypeList = [];
        foreach ($blockTypeListString['blocks'] as $blockTypeString) {
            $blockTypeList[] = new BlockType($blockTypeString);
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
